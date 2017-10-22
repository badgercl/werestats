#!/usr/bin/python
# -*- coding: utf8 -*-

import requests
import mysql.connector
import botconfig
from config import Config

import sys
reload(sys)
sys.setdefaultencoding('utf8')

url = "https://api.telegram.org/bot{}/".format(botconfig.TOKEN) + "{}"
chat_id = botconfig.GROUP_ID
def send_message(txt, dest):
	u = url.format("sendMessage")
	p = {'chat_id':dest,'parse_mode':'html','disable_web_page_preview':True, 'text':txt}
	r = requests.post(u,data=p)

sql = 'SELECT players.name AS name, player_stats_delta.uid, played, won, lost FROM player_stats_delta INNER JOIN ( ( SELECT MAX(id) id, MAX(date) FROM player_stats_delta GROUP BY uid ) b, players, roles ) ON( player_stats_delta.id = b.id AND player_stats_delta.uid = players.uid AND player_stats_delta.most_common_role_id = roles.id ) WHERE players.status > 0 ORDER BY player_stats_delta.played DESC LIMIT 5'
db = mysql.connector.Connect(**Config.dbinfo())
cursor = db.cursor()
cursor.execute('SET NAMES utf8mb4')
cursor.execute("SET CHARACTER SET utf8mb4")
cursor.execute("SET character_set_connection=utf8mb4")
cursor.execute(sql)
res = []
for row in cursor.fetchall():
	res.append(row)
cursor.close()
db.close()

i = 1
text = "Hay nuevas estadísticas de Werewolf Beauchef en <a href='https://badger.cl/werestats?from=bot'>https://badger.cl/werestats</a>.\nLos jugadores con más partidas son:\n"
for s in res:
	text += "{}.- <a href='https://badger.cl/werestats/user.php?uid={}&from=bot'>{}</a> ({} total, {} ganadas, {} perdidas)\n".format(i,s[1], s[0], s[2], s[3],s[4])
	i+=1
text += "\nPara aparecer en las estadísticas o actualizar tu nombre envía el comando /start por interno a @werewolf_beauchef_bot"
text += "\nAhora puedes pedir la lista de logros con /logros, revisar tus logros enviando el comando /mis_logros, pedir link de tus stats con /mis_stats o los de otros con /stats_de @usuario"
send_message(text,chat_id)
