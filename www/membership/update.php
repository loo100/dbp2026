<?php
  //檢查 cookie 中的 passed 變數是否等於 TRUE
  $passed = $_COOKIE["passed"];

  /* 如果 cookie 中的 passed 變數不等於 TRUE，
     表示尚未登入網站，將使用者導向首頁 index.html */
  if ($passed != "TRUE")
  {
    header("location: login.html");
    exit();
  }

  /* 如果 cookie 中的 passed 變數等於 TRUE，
     表示已經登入網站，則取得使用者資料 */
  else
  {
    require_once("db_config.php");

    //取得 modify.php 網頁的表單資料
    $id = $_COOKIE["id"];
    $password = $_POST["password"];
    $name = $_POST["name"];
    $sex = $_POST["sex"];
    $cellphone = $_POST["cellphone"];
    $email = $_POST["email"];
    $comment = $_POST["comment"];

    //執行 UPDATE 陳述式來更新使用者資料
        $sql = "UPDATE members2 SET password = ?, name = ?, sex = ?, cellphone = ?,
          email = ?, comment = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$password, $name, $sex, $cellphone, $email, $comment, $id]);
  }
?>
<!doctype html>
<html>
  <head>
    <title>修改會員資料成功</title>
    <meta charset="utf-8">
  </head>
  <body>
    <center>
      <img src="revise.jpg"><br><br>
      <?php echo $name ?>，恭喜您已經修改資料成功了。
      <p><a href="main.php">回會員專屬網頁</a></p>
    </center>
  </body>
</html>