<?php
session_start();

// 1. 清空 $_SESSION 陣列
$_SESSION = array();

// 2. 如果是透過 Cookie 傳遞 Session ID，建議也清除 Cookie
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 42000, '/');
}

// 3. 銷毀伺服器上的 Session 檔案
session_destroy();

// 4. 重定向到首頁或其他頁面
header("Location: index.html");
exit;
?>