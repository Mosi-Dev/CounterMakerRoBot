<?php
define('BOT_TOKEN','TOKEN');
$admin = ADMIN;
$channel = file_get_contents('channel.txt');
$update = json_decode(urldecode(file_get_contents('php://input')));
$user_id = $update->message->from->id;
$chat_id = $update->message->chat->id;
$name = $update->message->from->first_name;
$text = $update->message->text;
$msg_id = $update->message->message_id;
define('API_TELEGRAM','https://api.telegram.org/bot'.BOT_TOKEN.'/');
function save($filename,$TXTdata) {$myfile = fopen($filename, "w") or die("Unable to open file!");fwrite($myfile, "$TXTdata");fclose($myfile);}
if ($text == '/start') {file_get_contents(API_TELEGRAM.'sendChatAction?chat_id='.$chat_id.'&action=typing'); file_get_contents(API_TELEGRAM.'sendMessage?chat_id='.$chat_id.'&text=Hello '.$name.' please send message');}
elseif (strpos($text, "/setchannel ") !== false && $user_id == $admin) 
{$ch = str_replace("/setchannel ", "" ,$text); save("channel.txt", $ch);
file_get_contents(API_TELEGRAM.'sendMessage?chat_id='.$chat_id.'&text=*Channel* _$ch_ *Saved*&parse_mode=markdown');}
else {$to_channel = json_decode(urldecode(file_get_contents(API_TELEGRAM.'forwardMessage?chat_id='.$channel.'&from_chat_id='.$chat_id.'&message_id='.$msg_id)))->result->message_id; file_get_contents(API_TELEGRAM.'forwardMessage?chat_id='.$chat_id.'&from_chat_id='.$channel.'&message_id='.$to_channel);}
?>
