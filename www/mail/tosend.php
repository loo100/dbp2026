<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // 引入 PHPMailer

// 檢查是否為 POST 請求
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: tomail.html");
    exit();
}

// 接收表單資料
$sender_name = $_POST['sender_name'] ?? '';
$sender_email = $_POST['sender_email'] ?? '';
$recipient_name = $_POST['recipient_name'] ?? '';
$recipient_email = $_POST['recipient_email'] ?? '';
$subject = $_POST['subject'] ?? '';
$message = $_POST['message'] ?? '';

// 驗證必填欄位
if (empty($sender_name) || empty($sender_email) || empty($recipient_name) || 
    empty($recipient_email) || empty($subject) || empty($message)) {
    die("錯誤：所有欄位都必須填寫！<br><a href='tomail.html'>返回</a>");
}

// 驗證郵件格式
if (!filter_var($sender_email, FILTER_VALIDATE_EMAIL) || 
    !filter_var($recipient_email, FILTER_VALIDATE_EMAIL)) {
    die("錯誤：請輸入有效的電子郵件地址！<br><a href='tomail.html'>返回</a>");
}

try {
    // 建立 PHPMailer 物件
    $mail = new PHPMailer(true);

    // SMTP 伺服器設定 (以 Gmail 為例)
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'hw.pcchen@gmail.com';        // 請更改為您的 Gmail
    $mail->Password   = '--------------';           // 請更改為您的 Google 應用程式密碼
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;
    $mail->CharSet    = 'UTF-8';

    // 寄件人設定
    $mail->setFrom($mail->Username, $sender_name);
    $mail->addReplyTo($sender_email, $sender_name);

    // 收件人設定
    $mail->addAddress($recipient_email, $recipient_name);

    // 處理附件
    if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['attachment']['tmp_name'];
        $file_name = $_FILES['attachment']['name'];
        $file_size = $_FILES['attachment']['size'];
        
        // 檢查檔案大小 (10MB = 10485760 bytes)
        if ($file_size > 10485760) {
            throw new Exception("附件檔案過大，請選擇小於 10MB 的檔案!");
        }
        
        // 將附件加入郵件
        $mail->addAttachment($file_tmp, $file_name);
    }

    // 郵件內容設定
    $mail->isHTML(true);
    $mail->Subject = $subject;
    
    // 創建 HTML 郵件內容
    $html_message = "
    <html>
    <head>
        <style>
            body {
                font-family: Arial, sans-serif;
                line-height: 1.6;
                color: #333;
            }
            .email-container {
                max-width: 600px;
                margin: 0 auto;
                padding: 20px;
                border: 1px solid #ddd;
                border-radius: 5px;
            }
            .email-header {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                padding: 15px;
                border-radius: 5px 5px 0 0;
                text-align: center;
            }
            .email-body {
                padding: 20px;
                background: #f9f9f9;
            }
            .email-footer {
                margin-top: 20px;
                padding-top: 15px;
                border-top: 1px solid #ddd;
                font-size: 12px;
                color: #888;
            }
            .sender-info {
                margin-top: 15px;
                padding: 10px;
                background: #e8eaf6;
                border-left: 4px solid #667eea;
            }
        </style>
    </head>
    <body>
        <div class='email-container'>
            <div class='email-header'>
                <h2>📧 您收到一封新郵件</h2>
            </div>
            <div class='email-body'>
                " . nl2br(htmlspecialchars($message)) . "
                <div class='sender-info'>
                    <strong>寄件人：</strong> " . htmlspecialchars($sender_name) . "<br>
                    <strong>回覆信箱：</strong> " . htmlspecialchars($sender_email) . "
                </div>
            </div>
            <div class='email-footer'>
                此郵件透過郵件發送系統傳送
            </div>
        </div>
    </body>
    </html>
    ";
    
    $mail->Body = $html_message;
    $mail->AltBody = strip_tags($message) . "\n\n寄件人：" . $sender_name . "\n回覆信箱：" . $sender_email;

    // 發送郵件
    $mail->send();
    
    // 將資料傳遞到成功頁面
    session_start();
    $_SESSION['mail_data'] = [
        'sender_name' => $sender_name,
        'sender_email' => $sender_email,
        'recipient_name' => $recipient_name,
        'recipient_email' => $recipient_email,
        'subject' => $subject,
        'has_attachment' => isset($_FILES['attachment']) && $_FILES['attachment']['error'] == UPLOAD_ERR_OK
    ];
    
    header("Location: sended.php");
    exit();
    
} catch (Exception $e) {
    echo "郵件發送失敗！<br>";
    echo "錯誤訊息：" . $mail->ErrorInfo . "<br>";
    echo "<a href='tomail.html'>返回重試</a>";
}
?>
