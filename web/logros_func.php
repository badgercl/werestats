<?php
require_once('app/config.php');

function getLogros($uid){
$str = file_get_contents("http://www.tgwerewolf.com/Stats/PlayerAchievements/?pid=$uid");
if(!$str) return NULL;
$str = preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/', function ($match) {
	    return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
}, $str);

$res = [];
$trlen = preg_match_all ('#<tr[^>]*>(.*?)</tr>#s', $str, $tr);
foreach($tr[0] as $t){
	$tdlen = preg_match_all('/^<tr><td><b>(.*)<\/b><\/td><td>(.*)<\/td><\/tr>$/', $t, $td);
	$res[] = trim($td[1][0]);
}
return $res;
}

function index($arr){
	$res = [];
	foreach($arr as $a){ $res[$a['name']] = $a['id']; }
	return $res;
}

function joinLogros($db, $logros,$uid, $parsed){
	$user_logros = DbConfig::sql($db, "SELECT players_achievements.achievement_id as achievement_id, achievements.name as name FROM players_achievements JOIN (achievements) ON (achievements.id = players_achievements.achievement_id) WHERE player_id = $uid");
	$user_logros_n = array_map(function($e){return $e['name'];}, $user_logros );
	$logros_idx = index($logros);
	$new_logros = [];
	foreach($parsed as $p){
		if(!in_array($p, $user_logros_n)){
			$new_logros[] = "($uid ," . $logros_idx[$p] . ")";
		}
	}
	$sql = "INSERT INTO players_achievements (player_id, achievement_id) VALUES ".implode(",", $new_logros);
	DbConfig::update($db, $sql);
	if(count($new_logros)>0){
		$user_logros = DbConfig::sql($db, "SELECT players_achievements.achievement_id as achievement_id, achievements.name as name FROM players_achievements JOIN (achievements) ON (achievements.id = players_achievements.achievement_id) WHERE player_id = $uid");
	}
	return $user_logros;
}	


function compare($db, $user1, $user2, $chat_id){
	if(!$user1 || !$user2 || $user1 == $user2) {
		send_msg("Argumentos incorrectos. Uso: /comparar @usuario1 @usuario2", $chat_id);
		return;
	}	
	$tmpusers = DbConfig::sql($db,"SELECT id, uid, name, username FROM players WHERE username IN ('$user1', '$user2')");
	$users = [];
	foreach($tmpusers as $u){
		$users[$u['username']] = $u;
	}
	if(count($users) != 2){
		$missing = [];
		if(count($tmpusers)==0) $missing = [$user1, $user2];
		else{
		foreach($tmpusers as $t){
			if($user1 == $t['username']) break;
			$missing[] = $user1;
		}
		foreach($tmpusers as $t){
	                if($user2 == $t['username']) break;
		        $missing[] = $user2;
		}
		}
		$msg = "No puedo hacer la comparación hasta que ".implode(" y ", $missing)." me mande".(count($missing)>1?"n":"")." el comando /start a @werewolf_beauchef_bot por interno.";
		send_msg($msg, $chat_id);
		return;
	}
	$logros = DbConfig::sql($db, "SELECT id, name, description FROM achievements");
	$res1 = getLogros($users[$user1]['uid']);
	$res2 = getLogros($users[$user2]['uid']);
	$logros1 = joinLogros($db, $logros, $users[$user1]['uid'], $res1);
	$logros2 = joinLogros($db, $logros, $users[$user2]['uid'], $res2);
	print_r($logros1);
	print_r($logros2);	
}

function get_user_logros($db, $uid){
	$logros = DbConfig::sql($db, "SELECT id, name, description FROM achievements");
	$res1 = getLogros($uid);
	if(!$res1) return NULL;
	$logros1 = joinLogros($db, $logros, $uid, $res1);
	$logros_user = [];
	foreach($logros1 as $l){
		$logros_user[$l['achievement_id']] = $l['name'];
	}
	return [$logros, $logros_user];	
}
function send_msg($msg, $uid){
	echo "($uid)::$msg";
}


