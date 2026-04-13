<?php
require 'db_config.php';

// 獲取已添加的項目名稱
$name = $_GET['name'] ?? '新項目';
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>項目添加成功</title>
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

        .candidate-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #667eea;
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
        <h1>項目添加成功！</h1>
        <p class="message">新項目已成功添加到投票系統。</p>

        <div class="candidate-info">
            <strong>項目名稱：</strong> <?php echo htmlspecialchars($name); ?>
        </div>

        <div class="buttons">
            <a href="recommend.html" class="btn btn-primary">➕ 繼續新增項目</a>
            <a href="index.php" class="btn btn-secondary">🗳️ 返回投票頁面</a>
        </div>
    </div>
</body>
</html>
