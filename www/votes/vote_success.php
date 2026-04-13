<?php
require 'db_config.php';

// 獲取投票的項目名稱
$candidate_id = $_GET['candidate_id'] ?? null;
$candidate_name = '項目';

if ($candidate_id) {
    try {
        $stmt = $pdo->prepare("SELECT name FROM candidates WHERE id = ?");
        $stmt->execute([$candidate_id]);
        $candidate = $stmt->fetch();
        if ($candidate) {
            $candidate_name = $candidate['name'];
        }
    } catch (PDOException $e) {
        // 忽略錯誤，使用預設項目名稱
    }
}
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>投票成功</title>
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
            animation: bounce 0.8s ease-in-out;
        }

        @keyframes bounce {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.1);
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

        .vote-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #27ae60;
        }

        .vote-info strong {
            color: #27ae60;
        }

        .buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 12px 25px;
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
    </style>
</head>
<body>
    <div class="container">
        <div class="success-icon">✅</div>
        <h1>投票成功！</h1>
        <p class="message">您的投票已被記錄</p>

        <div class="vote-info">
            <strong>✓ 投票項目：</strong> <?php echo htmlspecialchars($candidate_name); ?>
        </div>

        <div class="buttons">
            <a href="index.php" class="btn btn-primary">🗳️ 繼續投票</a>
            <a href="result.php" class="btn btn-secondary">📊 查看結果</a>
        </div>
    </div>
</body>
</html>
