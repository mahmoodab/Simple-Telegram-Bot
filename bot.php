<?php
/*
* By Mahmood Abbas
* Telegram @ox_9n
*/

include("telegram.php");

$bot_id = "374075883:AAE4Ut-VIU39TvvEvYczP7EKz84B4Ax9jYI";
$api_key = "e496e314e83fd43e"


$telegram = new Telegram($bot_id);
$result = $telegram->getData();
$text = $result["message"] ["text"];
$chat_id = $telegram->ChatID();
//Get the file



if (strpos($text, '/url') !== false) {

	$wait = array('chat_id' => $chat_id, 'text' => "Wait Please............");
	$telegram->sendMessage($wait);

	$ctext = str_replace("/url ","",$text);

	$json = file_get_contents('http://api.page2images.com/restfullink?p2i_url='.$ctext.'&p2i_key='.$api_key);
	$obj = json_decode($json);
	$content = file_get_contents("$obj->image_url");
	//Store in the filesystem.
	$fp = fopen("image.jpg", "w");
	fwrite($fp, $content);
	fclose($fp);
if(isset($obj->image_url)){

	$img = curl_file_create('image.jpg','image/png');
	$content = array('chat_id' => $chat_id, 'photo' => $img );
	$telegram->sendPhoto($content);
}else{
	$error = array('chat_id' => $chat_id, 'text' => "Error Something wrong!");
	$telegram->sendMessage($error);

}
}elseif($text === "/start"){
	$d = array('chat_id' => $chat_id, 'text' => "Welcome To isave Bot By @ox_9n");
	$telegram->sendMessage($d);

}else{
    $s = array('chat_id' => $chat_id, 'text' => "Send /url + weburl to get screenshot for it");
	$telegram->sendMessage($s);

}

?>
