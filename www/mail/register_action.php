<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // 引入 Composer 自動載入
require 'db_config.php';

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    // 1. 產生唯一的啟用 Token
    $token = bin2hex(random_bytes(32));

    try {
        // 2. 存入資料庫 (狀態預設為 0)
        $stmt = $pdo->prepare("INSERT INTO members (username, email, password, token, is_active) VALUES (?, ?, ?, ?, 0)");
        $stmt->execute([$username, $email, $password, $token]);

        // 3. 配置 PHPMailer
        $mail = new PHPMailer(true);

        // --- 伺服器設定 (以 Gmail 為例) ---
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'hw.pcchen@gmail.com'; // 你的 Gmail
        $mail->Password   = '--------------';    // 你的 Google 應用程式密碼
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->CharSet    = 'UTF-8';

        // --- 收件人與內容 ---
        $mail->setFrom('hw.pcchen@gmail.com', '我的網站系統');
        $mail->addAddress($email, $username);

        $mail->isHTML(true);
        $mail->Subject = '感謝註冊！請啟用您的帳號';
        
        $activeLink = "http://localhost/verify.php?token=$token";
        $mail->Body    = "<h1>歡迎加入, $username!</h1>
                          <p>請點擊下方連結以啟用您的帳號：</p>
                          <a href='$activeLink'>啟用帳號</a>";

        $mail->send();
        echo "✅ 註冊成功！請檢查您的電子郵件以進行啟用。";

    } catch (Exception $e) {
        echo "❌ 寄信失敗: {$mail->ErrorInfo}";
    }
}
?>