from stem.descriptor.remote import Query
import os
import sqlite3
import json
import datetime

TRC_CONTACT_IDENTIFIER = "[tor-relay.co]"
DB_FILE_NAME = "trc.db"
STATS_FILE = "misc/stats.json"
NODES_GRAPH_FILE = "misc/nodes_graph.json"
BANDWIDTH_GRAPH_FILE = "misc/bandwidth_graph.json"

NODE_FIELDS = {
    "nickname":"TEXT",
    "fingerprint":"TEXT",
    "published":"DATETIME",
    "address":"TEXT",
    "or_port":"INT",
    "socks_port":"INT",
    "dir_port":"INT",
    "platform":"TEXT",
    "tor_version":"TEXT",
    "operating_system":"TEXT",
    "uptime":"INT",
    "contact":"TEXT",
    "exit_policy":"TEXT",
    "exit_policy_v6":"TEXT",
    "bridge_distribution":"TEXT",
    "family":"TEXT",
    "link_protocols":"TEXT",
    "circuit_protocols":"TEXT",
    "is_hidden_service_dir":"BOOLEAN",
    "hibernating":"BOOLEAN",
    "allow_single_hop_exits":"BOOLEAN",
    "allow_tunneled_dir_requests":"BOOLEAN",
    "extra_info_cache":"BOOLEAN",
    "extra_info_digest":"TEXT",
    "extra_info_sha256_digest":"TEXT",
    "ntor_onion_key":"TEXT",
    "or_addresses":"TEXT",
    "protocols":"TEXT"
}

STAT_FIELDS = {
    "average_bandwidth": "INT",
    "burst_bandwidth": "INT", 
    "observed_bandwidth": "INT"
}

class TorStatsUpdater(object):
    def __init__(self):
        if not os.path.exists(os.path.join(os.path.dirname(__file__), DB_FILE_NAME)):
            self.init_database()

    def init_database(self):
        print("Initializing new database file...")
        conn = sqlite3.connect(DB_FILE_NAME)
        c = conn.cursor()
        try:
            sql = "CREATE TABLE nodes(" + ", ".join([k + " " + v for k,v in NODE_FIELDS.items()]) + ", UNIQUE(fingerprint))"
            c.execute(sql)
            sql = "CREATE TABLE stats(node TEXT, measured DATETIME, " + ", ".join([k + " " + v for k,v in STAT_FIELDS.items()]) + ")"
            c.execute(sql)
            print("-> OK")
        except sqlite3.Error as e:
            print("SQLITE Error:", e)
        finally:
            conn.commit()
            conn.close()
    
    def update(self):
        print("Updating nodes from Tor API...")
        query = Query('/tor/server/all', timeout = 30)       
        measurement_time = datetime.datetime.now()
        conn = sqlite3.connect(DB_FILE_NAME)
        c = conn.cursor()
        current_node_count = 0
        current_combined_uptime = 0
        current_combined_bandwidth = 0
        nodes = []
        try:
            for desc in query.run():
                desc = self.parse_descriptor(desc)
                if desc["contact"] and TRC_CONTACT_IDENTIFIER in desc["contact"]:
                    current_node_count += 1
                    current_combined_uptime += desc["uptime"]
                    current_combined_bandwidth += desc["observed_bandwidth"]
                    nodes.append({'name': desc["nickname"], 'bandwidth': desc["observed_bandwidth"]})

                    insert_sql = "INSERT OR REPLACE INTO nodes(" + ", ".join(NODE_FIELDS.keys()) + ") "\
                                + "VALUES(" + ",".join(["?"] * len(NODE_FIELDS)) + ")"
                    try:
                        c.execute(insert_sql, tuple([desc[field] for field in NODE_FIELDS.keys()]))
                    except sqlite3.Error as e:
                        print("SQLITE Error:", e)

                    insert_sql = "INSERT OR REPLACE INTO stats(node, measured, " + ", ".join(STAT_FIELDS.keys()) + ") "\
                                + "VALUES(?,?," + ",".join(["?"] * len(STAT_FIELDS)) + ")"
                    try:
                        c.execute(insert_sql, tuple([desc["fingerprint"], measurement_time] + [desc[field] for field in STAT_FIELDS.keys()]))
                    except sqlite3.Error as e:
                        print("SQLITE Error:", e)     
            print("-> Updated {} nodes".format(current_node_count))
        except Exception as exc:
            print("Error:", exc)
        finally:
            conn.commit()
            conn.close()

    def parse_descriptor(self, desc):
        descDict = {}
        for field in list(NODE_FIELDS.keys()) + list(STAT_FIELDS.keys()):
            descDict[field] = getattr(desc, field)
        if desc.platform:
            descDict["platform"] = desc.platform.decode('utf-8', 'replace')
        if desc.contact:
            descDict["contact"] = desc.contact.decode('utf-8', 'replace')
        descDict["tor_version"] = str(descDict["tor_version"])
        descDict["bridge_distribution"] = str(descDict["bridge_distribution"])
        descDict["family"] = json.dumps(list(descDict["family"]))
        descDict["or_addresses"] = json.dumps(descDict["or_addresses"])
        descDict["protocols"] = json.dumps(descDict["protocols"])
        descDict["exit_policy"] = descDict["exit_policy"].summary()
        descDict["exit_policy_v6"] = descDict["exit_policy_v6"].summary()
        return descDict

    def export(self):
        print("Exporting node statistics...")
        conn = sqlite3.connect(DB_FILE_NAME)
        c = conn.cursor()
        # summary statistic
        stats_sql = """
            SELECT nodes.nickname, max(stats.observed_bandwidth) AS bw, max(nodes.uptime)
            FROM nodes, stats 
            WHERE 
                stats.node = nodes.fingerprint 
                AND stats.measured BETWEEN datetime((select max(stats.measured) FROM stats), '-2 days') AND (select max(stats.measured) FROM stats) 
            GROUP BY nodes.nickname
            ORDER BY bw DESC
        """

        # update over time statistics
        nodes_over_time_sql = """
            SELECT measured, count(*) 
            FROM (
                SELECT node, measured FROM stats GROUP BY node, strftime('%Y-%m-%d',measured)
            )
            GROUP BY strftime('%Y-%m-%d',measured)
            ORDER BY strftime('%Y-%m-%d',measured) DESC 
            LIMIT 61
        """

        bandwidth_over_time_sql = """
            SELECT datetime(measured), sum(bw) 
            FROM (
                SELECT min(average_bandwidth, burst_bandwidth, observed_bandwidth) as bw, measured FROM stats
            ) 
            GROUP BY strftime('%Y-%m-%d %H',measured) 
            ORDER BY strftime('%Y-%m-%d %H',measured) DESC 
            LIMIT 720
        """

        try:
            c.execute(stats_sql)
            stats = {
                "nodes": [],
                "bandwidth": 0,
                "uptime": 0
            }
            for node in c.fetchall():
                stats["nodes"].append({
                    "nickname": node[0],
                    "bandwidth": node[1],
                    "uptime": node[2],
                })
                stats["bandwidth"] += node[1]
                stats["uptime"] += node[2]
            with open(os.path.join(os.path.dirname(__file__), STATS_FILE), "w") as f:
                f.write(json.dumps(stats))

            c.execute(nodes_over_time_sql)
            nodes_over_time = []
            for day in c.fetchall():
                nodes_over_time.append({
                    "x": day[0],
                    "y": day[1]
                })
            with open(os.path.join(os.path.dirname(__file__), NODES_GRAPH_FILE), "w") as f:
                f.write(json.dumps(nodes_over_time))

            c.execute(bandwidth_over_time_sql)
            bandwidth_over_time = []
            for day in c.fetchall():
                bandwidth_over_time.append({
                    "x": day[0],
                    "y": day[1]
                })
            with open(os.path.join(os.path.dirname(__file__), BANDWIDTH_GRAPH_FILE), "w") as f:
                f.write(json.dumps(bandwidth_over_time))
            
            print("-> OK")
        except Exception as ex:
            print(ex)
        finally:
            conn.commit()
            conn.close()

if __name__ == '__main__':
    updater = TorStatsUpdater()
    updater.update()
    updater.export()
    print("=> All tasks finished")