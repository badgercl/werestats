# Werestats: improved Werewolf Stats

This project aims to provide better stats for the [Werewolf for Telegram game](http://www.tgwerewolf.com/). It gathers and processes the basic stats and shows them in a nicer way. 

Initially all was coded for the [Werewolf Beauchef Group](https://t.me/lacremedelawerewolf) and it's currently running on https://badger.cl/werestats/. This bot shows stats twice a day for the users previously registered. Also it has a web interface were players can check their history and compare to others. 

Most of the processing code is written in Python while the bot and web code is written on PHP 7.

# Installation

You'll need:
* A Telegram account
* A Telegram bot
* MySQL 5.5+
* PHP 7
* Python 2.7

You need to complete the following config files:
* config.py: Your DB information here
* botconfig.py: You bot information
* web/app/config.php: Your bot and DB information here

# TODO
* Refactor hardcoded URLs
* Fix some views showing incorrect stats
