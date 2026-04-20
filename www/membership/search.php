<?php
  require_once("db_config.php");
  require_once("pmail.inc.php");  // 
  header("Content-type: text/html; charset=utf-8");

  //取得表單資料
  $account = $_POST["account"];
  $email = $_POST["email"];
  $show_method = $_POST["show_method"];

  //檢查查詢的帳號是否存在
    $sql = "SELECT name, password FROM members2 WHERE account = ? AND email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$account, $email]);
    $row = $stmt->fetch(PDO::FETCH_OBJ);

  //如果帳號不存在
    if (!$row)
  {
    //顯示訊息告知使用者，查詢的帳號並不存在
    echo "<script type='text/javascript'>
            alert('您所查詢的資料不存在，請檢查是否輸入錯誤。');
            history.back();
          </script>";
  }
  else  //如果帳號存在
  {
    $name = $row->name;
    $password = $row->password;
    $message = "
      <!doctype html>
      <html>
        <head>
          <title></title>
          <meta charset='utf-8'>
        </head>
        <body>
          $name 您好，您的帳號資料如下：<br><br>
          　　帳號：$account<br>
          　　密碼：$password<br><br>
            <a href='index0.html'>按此登入本站</a>
          </body>
      </html>
    ";

    if ($show_method == "網頁顯示")
    {
      echo $message;   //顯示訊息告知使用者帳號密碼
    }
    else
    {
      $mail = getmail();
      $subject = "=?utf-8?B?" . base64_encode("帳號通知") . "?=";
      $headers  = "MIME-Version: 1.0\r\nContent-type: text/html; charset=utf-8\r\n";
      // mail($email, $subject, $message, $headers);
      $sendName = "=?utf-8?B?" . base64_encode("管理員") . "?=";
      $mail->setFrom("Admin@mystore.com", $sendName);
      $nameu = "=?utf-8?B?" . base64_encode("$name") . "?=";
      $mail->addAddress($email, $nameu);
      $mail->Subject = $subject;
      $mail->isHTML(true);
      $mail->Body = $message;
      if( !$mail->send() )
         echo "Mail not Sended. Error: ".$mail->ErrorInfo;
      else {
        //顯示訊息告知帳號密碼已寄至其電子郵件了
        echo "$name 您好，您的帳號資料已經寄至 $email<br><br>
              <a href='index0.html'>按此登入本站</a>";
      }
    }
  }
?>