<?php
require 'db_config.php';

try {
    // 從資料庫獲取所有候選項目
    $candidates_stmt = $pdo->query("SELECT * FROM candidates ORDER BY created_at DESC");
    $candidates = $candidates_stmt->fetchAll();

    // 如果有投票，檢查當前投票者是否已投過
    $voter_name = $_COOKIE['voter_name'] ?? null;
    $voted_candidate_id = null;
    $has_voted = false;
    
    if ($voter_name) {
        $voted_stmt = $pdo->prepare("SELECT candidate_id FROM votes WHERE voter_name = ? LIMIT 1");
        $voted_stmt->execute([$voter_name]);
        $voted_row = $voted_stmt->fetch();
        if ($voted_row) {
            $voted_candidate_id = (int) $voted_row['candidate_id'];
            $has_voted = true;
        }
    }

} catch (PDOException $e) {
    die("資料庫查詢失敗: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>投票系統</title>
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
            padding: 40px 20px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            color: white;
            margin-bottom: 40px;
        }

        .header h1 {
            font-size: 36px;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .voter-section {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .voter-form {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: center;
        }

        .voter-form input {
            flex: 1;
            min-width: 200px;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        .voter-form input:focus {
            outline: none;
            border-color: #667eea;
        }

        .voter-form button {
            padding: 12px 25px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            transition: background 0.3s;
        }

        .voter-form button:hover {
            background: #764ba2;
        }

        .voter-info {
            margin-top: 15px;
            padding: 15px;
            background: #e8eaf6;
            border-left: 4px solid #667eea;
            border-radius: 5px;
            display: <?php echo $voter_name ? 'block' : 'none'; ?>;
        }

        .voter-info strong {
            color: #667eea;
        }

        .candidates-section {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .candidates-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .candidates-table th,
        .candidates-table td {
            padding: 12px;
            border-bottom: 1px solid #e0e0e0;
            text-align: left;
            vertical-align: top;
        }

        .candidates-table th {
            background: #f8f9fa;
            color: #333;
            font-weight: 600;
        }

        .candidates-table tbody tr:hover {
            background: #f8f9fa;
        }

        .candidate-name {
            font-weight: 600;
            color: #333;
        }

        .candidate-desc {
            color: #666;
            font-size: 14px;
            line-height: 1.6;
        }

        .vote-actions {
            margin-top: 20px;
            text-align: right;
        }

        .vote-btn {
            padding: 12px 25px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s;
        }

        .vote-btn:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .vote-btn:disabled {
            background: #bdc3c7;
            cursor: not-allowed;
            opacity: 0.6;
        }

        .no-voter {
            background: #fff3cd;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            color: #856404;
            border-left: 4px solid #ffc107;
        }

        .already-voted {
            background: #d4edda;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            color: #155724;
            border-left: 4px solid #28a745;
        }

        .empty-state {
            text-align: center;
            color: white;
            padding: 50px 20px;
        }

        .empty-state h2 {
            margin-bottom: 20px;
        }

        .empty-state a {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 30px;
            background: white;
            color: #667eea;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .empty-state a:hover {
            background: #f0f0f0;
        }

        .nav-buttons {
            text-align: center;
            margin-top: 30px;
        }

        .nav-buttons a {
            display: inline-block;
            margin: 0 10px;
            padding: 12px 25px;
            background: white;
            color: #667eea;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .nav-buttons a:hover {
            background: #f0f0f0;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🗳️ 投票系統</h1>
            <p>請選擇您最喜歡的項目</p>
        </div>

        <div class="voter-section">
            <h3>👤 投票者驗證</h3>
            <form method="POST" action="set_voter.php" class="voter-form">
                <input type="text" name="voter_name" placeholder="請輸入您的名字" required 
                       value="<?php echo htmlspecialchars($voter_name ?? ''); ?>">
                <button type="submit">確認名字</button>
            </form>

            <?php if ($voter_name): ?>
                <div class="voter-info">
                    <strong>✅ 投票者：</strong> <?php echo htmlspecialchars($voter_name); ?>
                    <a href="logout_voter.php" style="margin-left: 15px; color: #667eea; font-size: 12px;">切換投票者</a>
                </div>
            <?php endif; ?>
        </div>

        <?php if (empty($candidates)): ?>
            <div class="empty-state">
                <h2>目前還沒有候選項目</h2>
                <p>請先新增候選項目再進行投票</p>
                <a href="recommend.html">➕ 新增候選項目</a>
            </div>
        <?php else: ?>
            <?php if (!$voter_name): ?>
                <div class="no-voter">
                    ⚠️ 請先輸入您的名字才能進行投票
                </div>
            <?php endif; ?>

            <?php if ($has_voted): ?>
                <div class="already-voted">
                    ✅ 此投票者已投過一個候選項目，無法再次投票。
                </div>
            <?php endif; ?>

            <div class="candidates-section">
                <form method="POST" action="vote.php">
                    <table class="candidates-table">
                        <thead>
                            <tr>
                                <th style="width: 80px;">選擇</th>
                                <th style="width: 200px;">候選名稱</th>
                                <th>說明</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($candidates as $candidate): ?>
                                <tr>
                                    <td>
                                        <input type="radio" name="candidate_id" value="<?php echo $candidate['id']; ?>"
                                            <?php echo !$voter_name || $has_voted ? 'disabled' : ''; ?>
                                            <?php echo $has_voted && $voted_candidate_id === (int) $candidate['id'] ? 'checked' : ''; ?>
                                        >
                                    </td>
                                    <td class="candidate-name"><?php echo htmlspecialchars($candidate['name']); ?></td>
                                    <td class="candidate-desc"><?php echo htmlspecialchars($candidate['description']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <div class="vote-actions">
                        <button type="submit" class="vote-btn" <?php echo !$voter_name || $has_voted ? 'disabled' : ''; ?>>
                            <?php echo !$voter_name ? '🔒 請先輸入名字' : ($has_voted ? '✓ 已投票' : '🗳️ 投票'); ?>
                        </button>
                    </div>
                </form>
            </div>

            <div class="nav-buttons">
                <a href="recommend.html">➕ 新增項目</a>
                <a href="result.php">📊 查看結果</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
