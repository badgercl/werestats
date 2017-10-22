#!/usr/bin/python
# -*- coding: utf8 -*-

import requests
from bs4 import BeautifulSoup
import re
import mysql.connector
from config import Config

import sys
reload(sys)
sys.setdefaultencoding('utf8')


#get roles
#get users
#get info from users
#parse results
#if role not in db -> insert in db -> get id, assign id
#insert PlayerStat in db

def get_roles(db):
    cursor = db.cursor()
    cursor.execute("SELECT id, name FROM roles")
    res = {}
    for row in cursor.fetchall():
        res[row[1]] = row[0]
    cursor.close()
    return res

def get_uids(db):
    cursor = db.cursor()
    cursor.execute("SELECT uid FROM players WHERE status = 1")
    res = []
    for row in cursor.fetchall():
        res.append(str(row[0]))
    cursor.close()
    return res

def add_role(name, roles, db):
    sql = "INSERT INTO roles (name) VALUES ('{}')".format(name)
    cursor = db.cursor()
    cursor.execute(sql)
    db.commit()
    return get_roles(db)

def disable_user(uid, db):
    print("Disabling "+uid)
    sql = "UPDATE players SET status = 2 WHERE uid = {}".format(uid)
    cursor = db.cursor()
    cursor.execute(sql)
    db.commit()

def get_stats(uid, roles, db):
    url = 'http://www.tgwerewolf.com/Stats/PlayerStats/?pid='+uid
    r = requests.get(url)
    s = BeautifulSoup(r.text.decode('unicode-escape'), 'html.parser')

    if len(s.text) < 10:
        disable_user(uid, db)
	return roles

    total = 0;
    won = 0;
    lost = 0;
    survived = 0;
    common_role = '';
    common_role_id = -1;
    most_killed = '';
    most_killed_count = 0;
    most_killed_by = '';
    most_killed_by_count = 0;

    for tr in s.select('tr'):
        td = tr.select('td')
        print "{} -> {}".format(td[0].text, td[1].text)
        if td[0].text == 'Games played total':
            total = td[1].text
        if td[0].text == 'Games won':
            won = td[1].text
        if td[0].text == 'Games lost':
            lost = td[1].text
        if td[0].text == 'Games survived':
            survived = td[1].text
        if td[0].text == 'Most common role':
            common_role = td[1].text.lower()
            if common_role in roles:
                common_role_id = roles[common_role]
            else:
                roles = add_role(common_role, roles, db)
                common_role_id = roles[common_role]
        if td[0].text == 'Most killed':
            most_killed_count = int(td[2].text.replace('times',''))
            most_killed = td[1].text.encode('latin-1').encode('utf8').strip()
        if td[0].text == 'Most killed by':
            most_killed_by_count = int(td[2].text.replace('times',''))
            most_killed_by = td[1].text.encode('latin-1').encode('utf8').strip()

    sql = "INSERT INTO player_stats (uid, played, won, lost, survived, most_common_role_id, most_killed, most_killed_name, most_killed_by, most_killed_by_name) VALUES ({},{},{},{},{},'{}',{},'{}',{},'{}')".format(uid, total, won, lost, survived, common_role_id, most_killed_count, most_killed, most_killed_by_count, most_killed_by)
    print(sql)
    try:
        cursor = db.cursor()
        cursor.execute('SET NAMES utf8mb4')
        cursor.execute("SET CHARACTER SET utf8mb4")
        cursor.execute("SET character_set_connection=utf8mb4")
        cursor.execute(sql)
        db.commit()
        cursor.close()
    except Exception as e:
        print(str(e))
    return roles


db = mysql.connector.Connect(**Config.dbinfo())
roles = get_roles(db)
uids = get_uids(db)

for uid in uids:
    roles = get_stats(uid, roles, db)
db.close()
