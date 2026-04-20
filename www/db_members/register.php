<?php
// --- 資料庫連線設定 ---
$host = '127.0.0.1';
$db   = 'test_db';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("資料庫連線失敗: " . $e->getMessage());
}

// --- 處理表單提交 ---
$msg = ""; // 用來顯示給使用者的訊息

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_name  = $_POST['username'];
    $user_email = $_POST['email'];
    $user_pass  = $_POST['password'];

    // 簡單檢查欄位是否為空
    if (!empty($user_name) && !empty($user_email) && !empty($user_pass)) {
        
        // 準備 SQL 指令 (使用佔位符 ? 確保安全)
        $sql = "INSERT INTO members (username, email, password) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        
        try {
            // 執行並存入資料庫
            $stmt->execute([$user_name, $user_email, $user_pass]);
            $msg = "<p style='color:green;'>✅ 註冊成功！歡迎你，$user_name 。</p>";
            echo "<script>alert('註冊成功！'); window.location.href = 'login.php';</script>";
        } catch (PDOException $e) {
            $msg = "<p style='color:red;'>❌ 註冊失敗: " . $e->getMessage() . "</p>";
        }
    } else {
        $msg = "<p style='color:orange;'>⚠️ 請填寫所有欄位。</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>會員註冊</title>
    <style>
        body { font-family: sans-serif; background-color: #f4f7f6; display: flex; justify-content: center; padding-top: 50px; }
        .reg-card { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); width: 300px; }
        input { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background-color: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background-color: #218838; }
    </style>
</head>
<body>

<div class="reg-card">
    <h2>📝 加入會員</h2>
    <?php echo $msg; ?>
    
    <form method="POST" action="register.php">
        <input type="text" name="username" placeholder="使用者名稱" required>
        <input type="email" name="email" placeholder="電子郵件" required>
        <input type="password" name="password" placeholder="設定密碼" required>
        <button type="submit">立即註冊</button>
    </form>
</div>

</body>
</html>