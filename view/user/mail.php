<?php
require_once '../../config/database.php';
require_once './../../controller/TodoController.php';
require_once './../../controller/LoginController.php';


$mail = "oott0228@gmail.com";
mb_language("Japanese");
mb_internal_encoding("UTF-8");
$email = $mail;
$subject = "会員登録ありがとうございます"; // 題名
$body = "本文本文本文本文本文本文本文本文本文\n"; // 本文
$to = $mail;
$header = "From: from@example.com";
$result = mb_send_mail($to, $subject, $body, $header);

