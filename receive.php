<?php
$json_str=file_get_contents('php://input');//接收REQUEST 的BODY
$json_obj=json_decode($json_str); //轉成json格式
 //產生回傳給line server的格式
 $sender_userid = $json_obj->events[0]->source->userId;
 $sender_txt = $json_obj->events[0]->message->text;
 $sender_replyToken = $json_obj->events[0]->replyToken;
 $line_server_url = 'https://api.line.me/v2/bot/message/push';
 switch ($sender_txt) {
    		case "push":
		 	$line_server_url = 'https://api.line.me/v2/bot/message/push';
        		$response = array (
				"to" => $sender_userid,
				"messages" => array (
					array (
						"type" => "text",
						"text" => "Hello, YOU SAY ".$sender_txt
					)
				)
			);
        		break;
    		case "reply":
			$line_server_url = 'https://api.line.me/v2/bot/message/reply';
        		$response = array (
				"replyToken" => $sender_replyToken,
				"messages" => array (
					array (
						"type" => "text",
						"text" => "Hello, YOU SAY ".$sender_txt
					)
				)
			);
        		break;
		case "image":
			$line_server_url = 'https://api.line.me/v2/bot/message/reply';
        		$response = array (
				"replyToken" => $sender_replyToken,
				"messages" => array (
					array (
						"type" => "image",
						"originalContentUrl" => "https://www.w3schools.com/css/paris.jpg",
						"previewImageUrl" => "https://www.nasa.gov/sites/default/themes/NASAPortal/images/feed.png"
					)
				)
			);
        		break;
 }


$myfile = fopen("log.txt","w+") or die("Unable to open file");  //設定LOG印訊息
fwrite($myfile,"\xEF\xBB\xBF".json_encode($response));//字串前加入"\xEF\xBB\xBF"轉成UTF-8格式
fclose($myfile);

 //回傳給line server
 $header[] = "Content-Type: application/json";
 $header[] = "Authorization: Bearer LDGfUJRlZUajOW7nrqgyvlZTPPUh3Gm7rjE4zPOtRgqGz/AJ/aAKwp827fKbkp7fFEH/zU3cPuWmpzy6Kd8ijDH9tfDYpl3jsB8KOmiR32AnZyxSY294S7+t1La71R1qPYKhj31uogb1bjhblm4s0AdB04t89/1O/w1cDnyilFU=";
 $ch = curl_init($line_server_url);                                                                      
 curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
 curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));                                                                  
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
 curl_setopt($ch, CURLOPT_HTTPHEADER, $header);                                                                                                   
 $result = curl_exec($ch);
 curl_close($ch); 

?>
