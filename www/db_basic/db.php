<?php
$host = 'localhost';
$db   = 'test_db';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // 開啟錯誤異常模式
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // 設定預設讀取為關聯陣列
    PDO::ATTR_EMULATE_PREPARES   => false,                  // 使用真實的預處理
];

try {
     $pdo = new PDO($dsn, $user, $pass, $options);
     echo "資料庫連線成功！";
} catch (\PDOException $e) {
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>