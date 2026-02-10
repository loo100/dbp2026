<?php
session_start();
// 模擬從表單收到的帳密驗證
$user = "admin";
$pass = "1234";
if ($_POST['username'] === $user && $_POST['password'] === $pass) {
    // 驗證成功，標記為已登入
    $_SESSION['is_logged_in'] = true;
    $_SESSION['username'] = $user;
    header("Location: dashboard.php");
    exit;
} else {
    echo "帳號或密碼錯誤";
}
?>
