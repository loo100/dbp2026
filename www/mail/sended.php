<?php
session_start();

// 檢查是否有郵件資料
if (!isset($_SESSION['mail_data'])) {
    header("Location: tomail.html");
    exit();
}

$mail_data = $_SESSION['mail_data'];

// 清除 session 資料
unset($_SESSION['mail_data']);
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>郵件發送成功</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Microsoft JhengHei', Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            max-width: 600px;
            width: 100%;
            text-align: center;
            animation: slideIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .success-icon {
            font-size: 80px;
            color: #27ae60;
            margin-bottom: 20px;
            animation: checkmark 0.8s ease-in-out;
        }

        @keyframes checkmark {
            0% {
                transform: scale(0);
                opacity: 0;
            }
            50% {
                transform: scale(1.2);
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        h1 {
            color: #27ae60;
            margin-bottom: 15px;
            font-size: 28px;
        }

        .message {
            color: #555;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .mail-info {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 8px;
            margin: 25px 0;
            text-align: left;
            border-left: 4px solid #667eea;
        }

        .mail-info h3 {
            color: #333;
            margin-bottom: 15px;
            font-size: 18px;
            text-align: center;
        }

        .info-row {
            margin: 10px 0;
            padding: 8px 0;
            border-bottom: 1px solid #e0e0e0;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: 600;
            color: #667eea;
            display: inline-block;
            width: 100px;
        }

        .info-value {
            color: #555;
        }

        .buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
        }

        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            background: #ecf0f1;
            color: #555;
        }

        .btn-secondary:hover {
            background: #bdc3c7;
        }

        .timestamp {
            margin-top: 20px;
            font-size: 14px;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="success-icon">✅</div>
        <h1>郵件發送成功！</h1>
        <p class="message">您的郵件已經成功送出，收件人將會收到您的訊息。</p>

        <div class="mail-info">
            <h3>📋 郵件資訊</h3>
            <div class="info-row">
                <span class="info-label">寄件人：</span>
                <span class="info-value"><?php echo htmlspecialchars($mail_data['sender_name']); ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">寄件信箱：</span>
                <span class="info-value"><?php echo htmlspecialchars($mail_data['sender_email']); ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">收件人：</span>
                <span class="info-value"><?php echo htmlspecialchars($mail_data['recipient_name']); ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">收件信箱：</span>
                <span class="info-value"><?php echo htmlspecialchars($mail_data['recipient_email']); ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">郵件主旨：</span>
                <span class="info-value"><?php echo htmlspecialchars($mail_data['subject']); ?></span>
            </div>
            <?php if ($mail_data['has_attachment']): ?>
            <div class="info-row">
                <span class="info-label">附件：</span>
                <span class="info-value">✅ 已包含附件</span>
            </div>
            <?php endif; ?>
        </div>

        <div class="buttons">
            <a href="tomail.html" class="btn btn-primary">✉️ 再發送一封</a>
            
        </div>

        <p class="timestamp">
            發送時間：<?php echo date('Y-m-d H:i:s'); ?>
        </p>
    </div>
</body>
</html>
