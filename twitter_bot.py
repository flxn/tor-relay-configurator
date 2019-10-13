# -*- coding: UTF-8 -*-
import sqlite3
import tweepy
import os
from dotenv import load_dotenv
load_dotenv()

DB_FILE_NAME = "trc.db"

if os.path.exists(os.path.join(os.path.dirname(__file__), DB_FILE_NAME)):
    conn = sqlite3.connect(DB_FILE_NAME)
    c = conn.cursor()

    c.execute("""
    SELECT measured, count(*)
    FROM (
        SELECT node, measured FROM stats GROUP BY node, strftime('%Y-%m-%d',measured)
    )
    GROUP BY strftime('%Y-%m-%d',measured)
    ORDER BY strftime('%Y-%m-%d',measured) DESC
    LIMIT 8
    """)

    nodes_today = 0
    nodes_last_week = 0
    for i, row in enumerate(c):
        if i == 0:
            nodes_today = row[1]
        if i == 7:
            nodes_last_week = row[1]

    c.execute("""
    SELECT datetime(measured), sum(bw)
    FROM (
        SELECT min(average_bandwidth, burst_bandwidth, observed_bandwidth) as bw, measured FROM stats
    )
    GROUP BY strftime('%Y-%m-%d %H',measured)
    ORDER BY strftime('%Y-%m-%d %H',measured) DESC
    LIMIT 8
    """)

    bandwidth_today = 0
    bandwidth_last_week = 0
    for i, row in enumerate(c):
        if i == 0:
            bandwidth_today = row[1] * 8 / 1000 / 1000
        if i == 7:
            bandwidth_last_week = row[1] * 8 / 1000 / 1000

    icon_up = "↗️"
    icon_down = "↘️"
    status_msg = "📊 Tor-Relay.co Weekly Stats\n{} {} nodes ({} last week)\n{} {:.0f} Mbit/s ({:.0f} last week)".format(
        icon_up if nodes_today >= nodes_last_week else icon_down,
        nodes_today,
        nodes_last_week,
        icon_up if bandwidth_today >= bandwidth_last_week else icon_down,
        bandwidth_today,
        bandwidth_last_week)

    print(status_msg)

    conn.close()

    auth = tweepy.OAuthHandler(os.getenv("CONSUMER_KEY"), os.getenv("CONSUMER_SECRET_KEY"))
    auth.set_access_token(os.getenv("ACCESS_TOKEN"), os.getenv("ACCESS_SECRET_TOKEN"))
    api = tweepy.API(auth)

    api.update_status(status_msg)
    print("=> Posted")
else:
    print("No database file found")
