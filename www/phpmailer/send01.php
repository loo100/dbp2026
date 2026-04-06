<?php
  require 'pmail.inc.php';

  //取得表單資料
  $from_name = "=?utf-8?B?" . base64_encode($_POST["from_name"]) . "?=";
  $from_email = $_POST["from_email"];
  $to_name = "=?utf-8?B?" . base64_encode($_POST["to_name"]) . "?=";
  $to_email = $_POST["to_email"];
  $subject = "=?utf-8?B?" . base64_encode($_POST["subject"]) . "?=";
  $message = $_POST["message"];

  //傳送郵件
  $mail = getmail();

  $mail->setFrom($from_email, $from_name);
  $mail->addReplyTo('pcchen@gm.nuu.edu.tw', 'First Last');
  $mail->addAddress($to_email, $to_name);
  $mail->Subject = $subject;
  $mail->Body=$message;

  if (!$mail->send()) {
      echo "Mailer Error: " . $mail->ErrorInfo;
  } else {
      echo "Message sent!";
  }