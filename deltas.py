#!/usr/bin/python
# -*- coding: utf8 -*-

import mysql.connector
from config import Config

import sys
reload(sys)
sys.setdefaultencoding('utf8')

def get_uids(db):
    cursor = db.cursor()
    cursor.execute("SELECT uid FROM players")
    res = []
    for row in cursor.fetchall():
        res.append(str(row[0]))
    cursor.close()
    return res

def get_last_two(db, uid):
	cursor = db.cursor()
	cursor.execute("SELECT played, won, lost, survived, most_common_role_id, most_killed, most_killed_name, most_killed_by, most_killed_by_name, updated FROM player_stats WHERE uid = {} ORDER BY updated DESC LIMIT 2".format(uid))
	res = []
	for row in cursor.fetchall():
		res.append(row)
	cursor.close()
	if len(res) != 2:
		return None
	else:
		return res

def process_delta(db, uid):
	d = get_last_two(db, uid)
	if d is None:
		return
	played = d[0][0]-d[1][0]
	won = d[0][1]-d[1][1]
	lost = d[0][2]-d[1][2]
	survived= d[0][3]-d[1][3]
	common_role_id = 0
	if d[1][4]!=d[0][4]:
		common_role_id = -d[0][4]
	else:
		common_role_id = d[0][4]
	most_killed = ''
	if d[1][6]!=d[0][6]:
		most_killed = '+'+d[0][6]+'-'+d[1][6]
	else:
		most_killed = d[0][6]
	most_killed_by = ''
	if d[1][8]!=d[0][8]:
                most_killed_by = '+'+d[0][8]+'-'+d[1][8]
        else:
                most_killed_by = d[0][8]
	most_killed_count = d[0][5]-d[1][5]
	most_killed_by_count = d[0][7]-d[1][7]
	date = d[0][9]
	print((uid, played, won, lost, survived, common_role_id, most_killed_count, most_killed_by_count, most_killed_by.decode('latin1')))
	sql = "INSERT INTO player_stats_delta (uid, played, won, lost, survived, most_common_role_id, most_killed, most_killed_name, most_killed_by, most_killed_by_name) VALUES ({},{},{},{},{},{},{},'{}',{},'{}')".format(uid, played, won, lost, survived, common_role_id, most_killed_count, most_killed, most_killed_by_count, most_killed_by)
	print(sql)
	cursor = db.cursor()
	cursor.execute(sql)
	db.commit()
	cursor.close()

db = mysql.connector.Connect(**Config.dbinfo())
uids = get_uids(db)
for uid in uids:
	process_delta(db, uid)

db.close()

