<?php
require 'db.php';
// 1. 準備 SQL 語法
$stmt = $pdo->prepare("UPDATE users SET name = :name, email = :email WHERE id = :id");

// 2. 執行並綁定參數
$stmt->execute(['name' => 'Alice', 'email' => 'alice@example.com',  'id' => 2]);

// 3. 準備 SQL 語法 (問號占位符)
$stmt = $pdo->prepare("UPDATE users SET name = ? , email = ? WHERE id = ?");
// 4. 執行並綁定參數 依照順序
$stmt->execute(['Jane', 'jane@example.com', 3]);


// 5. 顯示所有使用者
$sql = "SELECT * FROM users";
$users = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
foreach ($users as $user) {
    echo "<p>{$user['name']} ({$user['email']})</p>";
}

?>
