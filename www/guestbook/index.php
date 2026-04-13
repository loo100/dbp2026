<?php
// Read guestbook entries from database

header('Content-Type: text/html; charset=utf-8');

require 'db_config.php';

// Fetch all guestbook entries
try {
    $stmt = $pdo->query('SELECT id, name, message, created_at FROM guestbook ORDER BY created_at DESC');
    $entries = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $entries = [];
    $error = 'Error fetching guestbook: ' . $e->getMessage();
}

function escape($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="utf-8">
    <title>留言板</title>
    <style>
        body { font-family: system-ui, -apple-system, Arial, sans-serif; margin: 0; padding: 20px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; }
        h1 { color: #333; }
        .form-box { background: #fff; padding: 20px; border-radius: 8px; margin-bottom: 30px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; color: #333; }
        input[type="text"],
        textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-family: inherit; }
        textarea { resize: vertical; min-height: 100px; }
        button { background: #007bff; color: #fff; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; }
        button:hover { background: #0056b3; }
        .entry { background: #fff; padding: 15px; margin-bottom: 12px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .entry-name { font-weight: bold; color: #007bff; }
        .entry-time { font-size: 12px; color: #999; }
        .entry-message { margin-top: 8px; line-height: 1.6; color: #555; }
        .empty { color: #999; font-style: italic; }
        .error { color: #d32f2f; padding: 10px; background: #ffebee; border-radius: 4px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>留言板</h1>

        <?php if (isset($error)): ?>
            <div class="error"><?= escape($error) ?></div>
        <?php endif; ?>

        <div class="form-box">
            <h2>新增留言</h2>
            <form action="post.php" method="post">
                <div class="form-group">
                    <label for="name">姓名：</label>
                    <input type="text" id="name" name="name" required>
                </div>

                <div class="form-group">
                    <label for="message">留言：</label>
                    <textarea id="message" name="message" required></textarea>
                </div>

                <button type="submit">提交留言</button>
            </form>
        </div>

        <h2>留言記錄</h2>

        <?php if (empty($entries)): ?>
            <p class="empty">目前沒有留言。</p>
        <?php else: ?>
            <?php foreach ($entries as $entry): ?>
                <div class="entry">
                    <div class="entry-name">
                        <?= escape($entry['name']) ?>
                        <span class="entry-time"><?= escape($entry['created_at']) ?></span>
                    </div>
                    <div class="entry-message">
                        <?= nl2br(escape($entry['message'])) ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>
