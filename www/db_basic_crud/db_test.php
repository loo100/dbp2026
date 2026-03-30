<?php
$host = '127.0.0.1';
$db   = 'test_db';
$user = 'root';
$pass = ''; // Laragon 預設密碼為空
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // 開啟錯誤異常模式
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // 設定預設讀取為關聯陣列
    PDO::ATTR_EMULATE_PREPARES   => false,                  // 使用真實的預處理
];
try {
    // 建立連接
    $pdo = new PDO($dsn, $user, $pass, $options);
    echo "✅ 資料庫連線成功！";

} catch (PDOException $e) {
    echo "❌ 連線失敗: " . $e->getMessage();
}
?>