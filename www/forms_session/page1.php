<?php
session_start(); // 啟動 Session

// 存入資料
$_SESSION['user_name'] = "小明";
$_SESSION['user_role'] = "管理員";

echo "資料已記錄，<a href='page2.php'>去第二頁看看</a>";
?>
