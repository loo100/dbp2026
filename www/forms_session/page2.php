<?php
session_start(); // 每一頁都要啟動，才能拿到鑰匙讀取資料

if (isset($_SESSION['user_name'])) {
    echo "歡迎回來，" . $_SESSION['user_name'] . "！<br>";
    echo "您的權限是：" . $_SESSION['user_role'];
    }
else {
    echo "我不認識你，請先回到第一頁。";
    }
?>
