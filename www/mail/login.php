<?php
// 假設我們已經從資料庫根據 email 抓到了該使用者的資料
$user_from_db = [
    "username" => "Alex",
    "password" => '$2y$10$8K1X...' // 這是從資料庫抓出來的長長雜湊字串
];

$input_password = $_POST['password']; // 使用者在登入表單輸入的密碼

// 驗證密碼
if (password_verify($input_password, $user_from_db['password'])) {
    echo "✅ 登入成功！";
} else {
    echo "❌ 密碼錯誤，請再試一次。";
}
?>