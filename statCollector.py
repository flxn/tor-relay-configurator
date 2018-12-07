from stem.descriptor.remote import Query
import os
import sqlite3
import json
import datetime

TRC_CONTACT_IDENTIFIER = "[tor-relay.co]"
DB_FILE_NAME = "trc.db"

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

def parseDescriptor(desc):
    descDict = {}
    for field in list(NODE_FIELDS.keys()) + list(STAT_FIELDS.keys()):
        descDict[field] = getattr(desc, field)
    descDict["platform"] = str(descDict["platform"])
    descDict["contact"] = str(descDict["contact"])
    descDict["tor_version"] = str(descDict["tor_version"])
    descDict["bridge_distribution"] = str(descDict["bridge_distribution"])
    descDict["family"] = json.dumps(list(descDict["family"]))
    descDict["or_addresses"] = json.dumps(descDict["or_addresses"])
    descDict["protocols"] = json.dumps(descDict["protocols"])
    descDict["exit_policy"] = descDict["exit_policy"].summary()
    descDict["exit_policy_v6"] = descDict["exit_policy_v6"].summary()
    return descDict

if not os.path.exists(os.path.join(os.path.dirname(__file__), DB_FILE_NAME)):
    conn = sqlite3.connect(DB_FILE_NAME)
    c = conn.cursor()
    try:
        sql = "CREATE TABLE nodes(" + ", ".join([k + " " + v for k,v in NODE_FIELDS.items()]) + ", UNIQUE(fingerprint))"
        c.execute(sql)
        sql = "CREATE TABLE stats(node TEXT, measured DATETIME, " + ", ".join([k + " " + v for k,v in STAT_FIELDS.items()]) + ")"
        c.execute(sql)
        conn.commit()
    except sqlite3.Error as e:
        print("SQLITE Error:", e)
    finally:
        conn.close()

conn = sqlite3.connect(DB_FILE_NAME)
c = conn.cursor()

query = Query(
  '/tor/server/all',
  timeout = 30,
)

trcCount = 0
combinedUptime = 0
combinedBandwidth = 0

nodes = list()

try:
    for desc in query.run():
        desc = parseDescriptor(desc)
        if TRC_CONTACT_IDENTIFIER in desc["contact"]:
            trcCount += 1
            combinedUptime += desc["uptime"]
            combinedBandwidth += desc["observed_bandwidth"]
            nodes.append({'name': desc["nickname"], 'bandwidth': desc["observed_bandwidth"]})

            insert_sql = "INSERT OR IGNORE INTO nodes(" + ", ".join(NODE_FIELDS.keys()) + ") "\
                        + "VALUES(" + ",".join(["?"] * len(NODE_FIELDS)) + ")"
            try:
                c.execute(insert_sql, tuple([desc[field] for field in NODE_FIELDS.keys()]))
            except sqlite3.Error as e:
                print("SQLITE Error:", e)

            insert_sql = "INSERT OR IGNORE INTO stats(node, measured, " + ", ".join(STAT_FIELDS.keys()) + ") "\
                        + "VALUES(?,?," + ",".join(["?"] * len(STAT_FIELDS)) + ")"
            try:
                c.execute(insert_sql, tuple([desc["fingerprint"], datetime.datetime.now()] + [desc[field] for field in STAT_FIELDS.keys()]))
            except sqlite3.Error as e:
                print("SQLITE Error:", e)     
except Exception as exc:
    print("Error:", exc)
finally: 
    conn.commit()
    conn.close()

if len(nodes) > 0:
	with open(os.path.join(os.path.dirname(__file__), 'misc/stats.txt'), 'w') as fh:
    		fh.write(str(trcCount))
    		fh.write("\n")
    		fh.write(str(combinedUptime))
    		fh.write("\n")
    		fh.write(str(combinedBandwidth))

nodes = sorted(nodes, key=lambda k: k['bandwidth'], reverse=True);
if len(nodes) > 0:
    with open(os.path.join(os.path.dirname(__file__), 'misc/nodes.txt'), 'w') as fh:
        for node in nodes:
            fh.write(str(node['name']) + ';' + str(node['bandwidth']))
            fh.write("\n")

print(trcCount)
print(combinedUptime)
print(combinedBandwidth)
print(nodes)
