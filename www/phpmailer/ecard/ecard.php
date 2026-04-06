<?php
  require_once("db.php");

  //取得表單資料
  $card_id = $_POST["card_id"];
  $subject = $_POST["subject"];
  $from_name = $_POST["from_name"];
  $from_email = $_POST["from_email"];
  $to_name = $_POST["to_name"];
  $to_email = $_POST["to_email"];
  $music = $_POST["music"];
  $style = $_POST["style"];
  $size = $_POST["size"];
  $color = $_POST["color"];
  $message = $_POST["message"];
  $date = date("Y-m-d H:i:s");

  //執行 INSERT INTO 陳述式來將賀卡內容寫入 card_message 資料表
  $sql = "INSERT INTO card_message (card_id, subject, from_name, from_email,
      to_name, to_email, music, style, size, color, message, date)
      VALUES (:card_id, :subject, :from_name, :from_email,
      :to_name, :to_email, :music, :style, :size, :color,
      :message, :date)";
    $statement = $pdo->prepare($sql);
    $statement->execute([
      ':card_id' => $card_id,
      ':subject' => $subject,
      ':from_name' => $from_name,
      ':from_email' => $from_email,
      ':to_name' => $to_name,
      ':to_email' => $to_email,
      ':music' => $music,
      ':style' => $style,
      ':size' => $size,
      ':color' => $color,
      ':message' => $message,
      ':date' => $date,
    ]);

    //取得剛新增記錄的 id 欄位值
    $id = $pdo->lastInsertId();

  //設定檢視電子賀卡的網址
  //$current_url = "http://" . $_SERVER["REMOTE_ADDR"] . $_SERVER["PHP_SELF"];
  $current_url = "http://localhost/phpmailer/ecard/ecard.php";
  $get_ecard_url = str_replace("ecard.php", "get_ecard.php", $current_url);
  $get_ecard_url .= "?id=$id&subject=" . urlencode($subject);

  //指定郵件內容
  $message = "<h1 align='center'>翠墨資訊電子賀卡站</h1>";
  $message .= "<p>親愛的【" . $to_name . "】：</p>";
  $message .= "<p>【" . $from_name . "】透過本站寄給您一張電子賀卡</p>";
  $message .= "<p>您可以到以下網址觀看您的卡片：</p>";
  $message .= "<p align='center'><a href='$get_ecard_url'>";
  $message .= "按此可以觀看卡片</a></p>";
  $message .= "<p align='right'>寄件日期：$date</p>";

  $subject = "=?utf-8?B?" . base64_encode($subject) . "?=";
  $from_name = "=?utf-8?B?" . base64_encode($from_name) . "?=";
  $to_name = "=?utf-8?B?" . base64_encode($to_name) . "?=";

  //若要傳送 HTML 格式的郵件，須指定 Content-type 標頭資訊
  // $headers  = "MIME-Version: 1.0\r\n";
  // $headers .= "Content-type: text/html; charset=utf-8\r\n";
  // $headers .= "From: $from_name<$from_email>\r\n";
  // $headers .= "To: $to_name<$to_email>\r\n";
  //
  // //傳送郵件
  // mail($to_email, $subject, $message, $headers);
  require 'pmail.inc.php';
  $mail = getmail();
  $mail->setFrom($from_email, $from_name);
  //Set who the message is to be sent to
  $mail->addAddress($to_email, $to_name);
  //Set the subject line
  $mail->Subject = $subject;
  $mail->msgHTML($message);
  if (!$mail->send()) {
      echo "Mailer Error: " . $mail->ErrorInfo;
  } else {
      echo "Message sent!<br>";
      echo "<a href='index0.php'>回系統首頁</a>";
      //Section 2: IMAP
      //Uncomment these to save your message in the 'Sent Mail' folder.
      #if (save_mail($mail)) {
      #    echo "Message saved!";
      #}
  }

?>
