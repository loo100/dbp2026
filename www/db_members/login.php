<?php
session_start();

// --- 資料庫連線設定 ---
$host = '127.0.0.1';
$db = 'test_db';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die('資料庫連線失敗: ' . $e->getMessage());
}

$msg = '';
$login_success = false;
$input_email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input_email = trim($_POST['email'] ?? '');
    $input_password = $_POST['password'] ?? '';

    if ($input_email === '' || $input_password === '') {
        $msg = "<p style='color:orange;'>⚠️ 請輸入 Email 與密碼。</p>";
    } else {
        $sql = 'SELECT id, username, email, password FROM members WHERE email = ? LIMIT 1';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$input_email]);
        $user_from_db = $stmt->fetch();

        if ($user_from_db) {
            $stored_password = $user_from_db['password'];

            // 支援雜湊密碼，也相容於教學早期直接存明文的資料。
            $is_valid_password = password_verify($input_password, $stored_password) || $input_password === $stored_password;

            if ($is_valid_password) {
                $_SESSION['member_id'] = $user_from_db['id'];
                $_SESSION['member_name'] = $user_from_db['username'];
                $_SESSION['member_email'] = $user_from_db['email'];

                $login_success = true;
                $safe_name = htmlspecialchars($user_from_db['username'], ENT_QUOTES, 'UTF-8');
                $msg = "<p style='color:green;'>✅ 登入成功！歡迎回來，{$safe_name}。</p>";
            } else {
                $msg = "<p style='color:red;'>❌ 密碼錯誤，請再試一次。</p>";
            }
        } else {
            $msg = "<p style='color:red;'>❌ 查無此 Email 帳號。</p>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>會員登入</title>
    <style>
        body {
            font-family: sans-serif;
            background-color: #f4f7f6;
            display: flex;
            justify-content: center;
            padding-top: 50px;
        }
        .login-card {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 320px;
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="login-card">
    <h2>會員登入</h2>
    <?php echo $msg; ?>

    <?php if (!$login_success): ?>
        <form action="login.php" method="post">
            <label for="email">Email：</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($input_email, ENT_QUOTES, 'UTF-8'); ?>" required>

            <label for="password">密碼：</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">登入</button>
        </form>
    <?php else: ?>
        <p><a href="register.php">尚未註冊？前往註冊</a></p>
    <?php endif; ?>
</div>
</body>
</html>