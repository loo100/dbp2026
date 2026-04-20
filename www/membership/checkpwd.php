<?php
require_once("db_config.php");
header("Content-type: text/html; charset=utf-8");

//取得表單資料
$account = $_POST["account"];
$password = $_POST["password"];

//檢查帳號密碼是否正確
$sql = "SELECT id FROM members2 WHERE account = ? AND password = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$account, $password]);
$member = $stmt->fetch(PDO::FETCH_ASSOC);

//如果帳號密碼錯誤
if (!$member)
{
  //顯示訊息要求使用者輸入正確的帳號密碼
  echo "<script type='text/javascript'>";
  echo "alert('帳號密碼錯誤，請查明後再登入');";
  echo "history.back();";
  echo "</script>";
}

//如果帳號密碼正確
else
{
  //取得 id 欄位
  $id = $member["id"];

  //將使用者資料加入 cookies
  setcookie("id", $id);
  setcookie("passed", "TRUE");
  header("location:main.php");
}