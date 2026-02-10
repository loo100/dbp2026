<?php
session_start();

// 檢查是否有登入標記
if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
    // 沒登入就踢回首頁
    header("Location: index.html");
    exit;
}

echo "這是秘密後台，管理員 " . $_SESSION['username'] . " 您好。";
?>
