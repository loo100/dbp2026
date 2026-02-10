<?php
// 假設我們已經從資料庫根據 email 抓到了該使用者的資料
$user_from_db = [
    "username" => "cherry",
    "password" => '$2y$10$4wagLcvwvl686HV.u5e7muyt0u/o4FZbPygsHYQWGVhOcVhQqvGma' // 這是從資料庫抓出來的長長雜湊字串
];

$input_password = $_POST['password']; // 使用者在登入表單輸入的密碼

// 驗證密碼
if (password_verify($input_password, $user_from_db['password'])) {
    echo "✅ 登入成功！";
} else {
    echo "❌ 密碼錯誤，請再試一次。";
}
?>