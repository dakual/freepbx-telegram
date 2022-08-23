#!/usr/bin/php -q
<?php
// nano /var/lib/asterisk/agi-bin/telegram.php
require('phpagi.php');
$agi = new AGI();
$stdin = fopen('php://stdin', 'r');
$stdout = fopen('php://stdout', 'w');


function send($token, $chatid, $text, $proxy=NULL, $auth=NULL){
	$ch=curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://api.telegram.org/bot'.$token.'/sendMessage');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, 'chat_id='.$chatid.'&text='.urlencode($text).'&parse_mode=html');
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
	curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
	
	if($auth){
		curl_setopt($ch, CURLOPT_PROXYUSERPWD, $auth);
	}

	$result=curl_exec($ch);

	var_dump($result);
	curl_close($ch);
	return $result;
}

$token='';
$chatIds = array("","");
$text  = "<b>Пропущенный звонок</b>\n";
$text .= "Номер: " . $argv[1] . "\n";
$text .= "Дата: " . $argv[2];

$agi->verbose("Telegram send caller number:$argv[1] Caller Date:$argv[2]");

foreach($chatIds as $chatId) {
	send($token, $chatId, $text);
	sleep(10);
}

fclose ($stdin);
fclose ($stdout);
exit(0);
?>