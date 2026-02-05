<?php
// 後端邏輯：連接資料庫
$host = 'localhost';
$db   = 'test_db';
$user = 'root';
$pass = ''; // Laragon 預設無密碼

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 取得資料
    $stmt = $pdo->query("SELECT * FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("資料庫連線失敗: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>我的第一個全端網頁</title>
    <style>
        body { font-family: sans-serif; background: #f4f4f4; padding: 50px; }
        .card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        h1 { color: #333; }
    </style>
</head>
<body>
    <div class="card">
        <h1>使用者列表</h1>
        <ul>
            <?php foreach ($users as $user): ?>
                <li><?php echo $user['name']; ?> (<?php echo $user['email']; ?>)</li>
            <?php endforeach; ?>
        </ul>
    </div>
    <h3>W3School 連結</h3>
    <div class="card">
        <h2>W3School 教學 基礎語法</h2>
        <ul>
            <li><a href="https://www.w3schools.com" target="_blank">W3Schools</a></li>
            <li><a href="https://www.w3schools.com/html" target="_blank">HTML 教學</a></li>
            <li><a href="https://www.w3schools.com/css" target="_blank">CSS 教學</a></li>
            <li><a href="https://www.w3schools.com/php" target="_blank">PHP 教學</a></li>
            <li><a href="https://www.w3schools.com/js" target="_blank">JavaScript 教學</a></li>
        </ul>
    </div>
</body>
</html>