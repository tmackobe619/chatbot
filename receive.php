<?php
$json_str=file_get_contents('php://input');//接收REQUEST 的BODY
$json_obj=json_decode($json_str); //轉成json格式
 //產生回傳給line server的格式
 $sender_userid = $json_obj->events[0]->source->userId;
 $sender_txt = $json_obj->events[0]->message->text;
 $sender_replyToken = $json_obj->events[0]->replyToken;
 $response = array (
				"replyToken" => $sender_replyToken,
				"messages" => array (
					array (
						"type" => "text",
						"text" => "Hello, YOU SAY ".$sender_txt
					)
				)
		);

$myfile = fopen("log.txt","w+") or die("Unable to open file");  //設定LOG印訊息
fwrite($myfile,"\xEF\xBB\xBF".json_encode($response));//字串前加入"\xEF\xBB\xBF"轉成UTF-8格式
fclose($myfile);

 //回傳給line server
 $header[] = "Content-Type: application/json";
 $header[] = "Authorization: Bearer WzZtuOblOl7l+EXV6bamontyxP2/RBGD7L78qyFyUxrV+SYfYYJihgkgWNn+YIcaFuXaty2pvJ9lRUpZ6d4BKEyAbM4SFb3+561BWJDMAvGYJQoTq0a32j7yN5yF6/qt0nlGDh3PCJzRPL9WcVw39QdB04t89/1O/w1cDnyilFU=";
 $ch = curl_init("https://api.line.me/v2/bot/message/reply");                                                                      
 curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
 curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));                                                                  
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
 curl_setopt($ch, CURLOPT_HTTPHEADER, $header);                                                                                                   
 $result = curl_exec($ch);
 curl_close($ch); 

?>
