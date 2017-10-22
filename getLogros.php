<?php
$url = "https://raw.githubusercontent.com/GreyWolfDev/Werewolf/master/Werewolf%20for%20Telegram/Database/Achievements.cs";
$str = file_get_contents($url);
$str = preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/', function ($match) {
	            return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
}, $str);


$res = [];
$q = [];
$trlen = preg_match_all ('(\[Display.*\])', $str, $tr);
foreach($tr[0] as $t){
	        $tdlen = preg_match_all('/^\[Display\(Name\s?=\s?"(.*)"\), Description\("(.*)"\)\]$/', $t, $td);
		//print_r($td);
		$res[] = ['name'=>$td[1][0],'desc'=>$td[2][0]];
		$name = str_replace("'", "\'", $td[1][0]);
		$desc = str_replace("'", "\'", $td[2][0]);
		$q[] = "('$name','$desc')";

}

$sql = "INSERT INTO achievements (name, description) VALUES ". implode(",",$q);
die($sql);
