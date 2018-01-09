<?php
$json_str=file_get_contents('php://input');//接收REQUEST 的BODY
$json_obj=json_decode($json_str); //轉成json格式

$myfile = fopen("log.txt","w+") or die("Unable to open file");  //設定LOG印訊息
fwrite($myfile,"\xEF\xBB\xBF".$json_str);//字串前加入"\xEF\xBB\xBF"轉成UTF-8格式
fclose($myfile);
 
echo $json_obj

?>
