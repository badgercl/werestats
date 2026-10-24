<?php
require_once('../app/config.php');


$postData = file_get_contents('php://input');
if(!isset($postData) || !$postData) die('1'); //Save to database?
$json = json_decode($postData, true);
if( !isset($json['message']) ) return;
$m = $json['message'];
if(!isset($m['text'])) die();


// It should only work in La crêmè dé la ŴEŔĚŴØLF
if($m['chat']['id'] != -1001369480858) {
	ERROR_LOG("not the target group");
	return;
} 

$text = $m['text'];
if(strpos(strtolower($text), '/start') === 0){
  start($m, $token);
}
else if(strpos(strtolower($text), '/logros') === 0){
	show_logros($m,$token);
}
else if(strpos(strtolower($text), '/mis_logros') === 0){
        show_mis_logros($m,$token);
}
else if(strpos(strtolower($text), '/stats_de') === 0){
        stats_de($m,$token);
}
else if(strpos(strtolower($text), '/mis_stats') === 0){
        mis_stats($m,$token);
}

function send_error($msg, $token){
global $admin_uid;
send_msg($msg, $admin_uid, $token);
}

function send_msg($msg, $uid, $token){
$msg = urlencode($msg);
$cmd = "https://api.telegram.org/$token/sendMessage?chat_id=$uid&text=$msg&parse_mode=HTML";
file_get_contents($cmd);
}

function start($m, $token){
  $db = DbConfig::getConnection();
  $f = $m['from'];
  $uid = $db->real_escape_string($f['id']);

  $name = isset($f['first_name'])?$f['first_name']:"";
  $name .= " ";
  $name .= isset($f['last_name'])?$f['last_name']:"";
  $name = $db->real_escape_string(trim($name));
  if(strlen($name) === 0) $name = $db->real_escape_string($f['username']);  
  if(strlen($name) === 0) {
	$msg = "El usuario $uid no tiene nombre!!";
	error_log($msg);
	send_error($msg, $token);
	send_msg("No pudimos completar la operación, vamos revisar que sucedió", $uid, $token);
	die();
}
  $username = isset($f['username'])?$db->real_escape_string("@".$f['username']):$name;
  if(strlen($username) <= 1) $username = $name; 
  $msg = "Surgió un error, por favor avísale a @badger_cl";
  $sql = "SELECT * FROM players WHERE uid = '$uid'";
  $res = DbConfig::sql($db, $sql);
  if(count($res)==0){
    $sql = "INSERT INTO players (uid, name, username) VALUES ('$uid', '$name', '$username')";
    $res_insert = DbConfig::update($db, $sql);
    if(!$res_insert) error_log($db->error);
    else $msg = "Te hemos ingresado a la base de jugadores, en un día aparecerán tus stats";
  }
  else{
    $sql = "UPDATE players SET name='$name', status=1, username='$username' WHERE uid='$uid'";
    $res_insert = DbConfig::update($db, $sql);    
    if(!$res_insert) error_log($db->error);
	else return;
    //else $msg = "Hemos actualizado tus datos!";
  }
send_msg($msg, $uid, $token);
}

function show_logros($m, $token){
	$txt = "Aquí esta la lista de logros: <a href='https://badger.cl/werestats/logros.php?from=bot'>https://badger.cl/werestats/logros.php</a>";
	send_msg($txt, $m['chat']['id'], $token);
}

function show_mis_logros($m, $token){
	$uid = $m['from']['id'];
	$db = DbConfig::getConnection();
	$u = DbConfig::sql($db,"SELECT name, username FROM players WHERE uid = $uid");
	if(!$u) {
		$txt = "Primero tienes que mandar el comando /start por interno al bot @werewolf_beauchef_bot"; 
	}
	else {
		$txt = "Tus logros estan aquí: <a href='https://badger.cl/werestats/logros_user.php?uid=$uid&from=bot'>https://badger.cl/werestats/logros_user.php?uid=$uid</a>";
	}
	send_msg($txt, $m['chat']['id'], $token);
}

function stats_de($m, $token){
	error_log('sats');
	$db = DbConfig::getConnection();
	$text = trim(str_replace("@werewolf_beauchef_bot","",str_replace("/stats_de","",$m['text'])));
	$username = $db->real_escape_string(get_username($text));
	if(!$username){
		$txt = "El usuario no es válido, debe ser un @";
	}
	else {
		$u = DbConfig::sql($db,"SELECT name, username, uid FROM players WHERE username = '$username'");
		if(!$u){
			$txt = "No conozco al usuario $username, dile que mande /start por interno a @werewolf_beauchef_bot";
		}else{
			$uid = $u[0]['uid'];
			$txt = "Los stats de $username estan en <a href='https://badger.cl/werestats/user.php?uid=$uid&from=bot'>https://badger.cl/werestats/user.php?uid=$uid</a>";
		}
	}
	send_msg($txt, $m['chat']['id'], $token);
}

function mis_stats($m, $token){
	$uid = $m['from']['id'];
	$db = DbConfig::getConnection();
        $u = DbConfig::sql($db,"SELECT name, username FROM players WHERE uid = $uid");
	if(!$u) $txt = "Primero tienes que mandar el comando /start por interno al bot @werewolf_beauchef_bot";
	else $txt = "Tus stats están en <a href='https://badger.cl/werestats/user.php?uid=$uid&from=bot'>https://badger.cl/werestats/user.php?uid=$uid</a>";
	send_msg($txt, $m['chat']['id'], $token);
}

function get_username($txt){
	$p = explode(" ", $txt);
	if($p & strlen($p[0]) > 0 && $p[0]{0} == '@'){
		return $p[0];
	}
	return NULL;
}
