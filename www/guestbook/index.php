<?php
session_start();
header('Content-Type: text/html; charset=utf-8');

require 'db_config.php';

$page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, [
    'options' => ['default' => 1, 'min_range' => 1],
]);
$perPage = 5;
$offset = ($page - 1) * $perPage;

try {
    $totalStmt = $pdo->query('SELECT COUNT(*) FROM guestbook');
    $totalEntries = (int) $totalStmt->fetchColumn();

    $pendingStmt = $pdo->query("SELECT COUNT(*) FROM guestbook WHERE status = 'pending'");
    $pendingCount = (int) $pendingStmt->fetchColumn();

    $stmt = $pdo->prepare(
        'SELECT g.id, g.message, g.status, g.created_at,
            COALESCE(u.nickname, u.username, g.name, "訪客") AS display_name,
            COALESCE(u.avatar, "👤") AS avatar,
            COALESCE(u.favorite_color, "#f5f5f5") AS favorite_color
        FROM guestbook g
        LEFT JOIN users u ON u.id = g.user_id
        ORDER BY g.created_at DESC
        LIMIT :limit OFFSET :offset'
    );
    $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $entries = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $entries = [];
    $error = 'Error fetching guestbook: ' . $e->getMessage();
}

function escape($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function statusLabel($status)
{
    switch ($status) {
        case 'approved':
            return '<span class="status approved">已審核</span>';
        case 'pending':
        default:
            return '<span class="status pending">待審核</span>';
    }
}
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="utf-8">
    <title>留言板</title>
    <style>
        body { font-family: system-ui, -apple-system, Arial, sans-serif; margin: 0; padding: 20px; background: #f5f5f5; }
        .container { max-width: 900px; margin: 0 auto; }
        .header { text-align: right; margin-bottom: 10px; }
        h1 { color: #333; }
        .summary { margin-bottom: 20px; color: #555; }
        .form-box, .entry, .pagination { background: #fff; padding: 20px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.08); }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; color: #333; }
        textarea, input[type="color"] { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-family: inherit; }
        textarea { resize: vertical; min-height: 100px; }
        button, .action-button { background: #007bff; color: #fff; padding: 10px 18px; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; text-decoration: none; display: inline-block; }
        button:hover, .action-button:hover { background: #0056b3; }
        .entry { padding: 0; overflow: hidden; }
        .entry-body { padding: 18px; }
        .entry-name { font-weight: bold; color: #007bff; }
        .entry-time { font-size: 12px; color: #999; margin-left: 10px; }
        .entry-message { margin-top: 10px; line-height: 1.7; color: #333; white-space: pre-wrap; }
        .entry-footer { margin-top: 15px; display: flex; flex-wrap: wrap; gap: 10px; align-items: center; }
        .status { padding: 4px 10px; border-radius: 999px; font-size: 12px; color: #fff; }
        .approved { background: #28a745; }
        .pending { background: #ffc107; color: #333; }
        .empty { color: #666; font-style: italic; }
        .error { color: #d32f2f; padding: 10px; background: #ffebee; border-radius: 4px; margin-bottom: 20px; }
        .pagination { text-align: center; }
        .pagination a { margin: 0 6px; color: #007bff; text-decoration: none; }
        .pagination a.current { font-weight: bold; color: #333; }
        .pagination a.disabled { color: #999; pointer-events: none; }
        .admin-note { font-size: 14px; color: #555; margin-bottom: 15px; }
        .actions form { display: inline-block; margin: 0; }
        .avatar { margin-right: 6px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <?php if (isset($_SESSION['user_id'])): ?>
                <p>歡迎，<?= escape($_SESSION['nickname'] ?? $_SESSION['username'] ?? '訪客') ?>！
                <?php if (!empty($_SESSION['is_admin'])): ?>
                    <a href="admin.php">會員管理</a> |
                <?php endif; ?>
                <a href="logout.php">登出</a></p>
            <?php else: ?>
                <p><a href="login.php">登入</a> | <a href="register.php">註冊</a></p>
            <?php endif; ?>
        </div>
        <h1>留言板</h1>

        <div class="summary">
            <strong>留言總數：</strong> <?= isset($totalEntries) ? escape($totalEntries) : '0' ?>
            &nbsp;|&nbsp;
            <strong>待審核：</strong> <?= isset($pendingCount) ? escape($pendingCount) : '0' ?>
        </div>

        <?php if (isset($error)): ?>
            <div class="error"><?= escape($error) ?></div>
        <?php endif; ?>

        <?php if (isset($_SESSION['user_id'])): ?>
        <div class="form-box">
            <h2>新增留言</h2>
            <form action="post.php" method="post">
                <div class="form-group">
                    <label for="message">留言：</label>
                    <textarea id="message" name="message" required maxlength="5000"></textarea>
                </div>
                <button type="submit">提交留言</button>
            </form>
        </div>
        <?php else: ?>
        <div class="form-box">
            <p>請 <a href="login.php">登入</a> 以新增留言。</p>
        </div>
        <?php endif; ?>

        <div class="admin-note">管理員可審核留言、刪除留言，第一位註冊的帳號會成為管理員。</div>

        <h2>留言記錄</h2>

        <?php if (empty($entries)): ?>
            <p class="empty">目前沒有留言。</p>
        <?php else: ?>
            <?php foreach ($entries as $entry): ?>
                <div class="entry" style="background: <?= escape($entry['favorite_color'] ?? '#f5f5f5') ?>20; border: 1px solid <?= escape($entry['favorite_color'] ?? '#f5f5f5') ?>;">
                    <div class="entry-body">
                        <div class="entry-name">
                            <span class="avatar"><?= escape($entry['avatar'] ?? '👤') ?></span>
                            <?= escape($entry['display_name'] ?? ($entry['name'] ?? '訪客')) ?>
                            <span class="entry-time"><?= escape($entry['created_at']) ?></span>
                        </div>
                        <div class="entry-message">
                            <?= nl2br(escape($entry['message'])) ?>
                        </div>
                        <div class="entry-footer">
                            <?= statusLabel($entry['status']) ?>
                            <?php if (!empty($_SESSION['is_admin'])): ?>
                                <div class="actions">
                                    <?php if ($entry['status'] === 'pending'): ?>
                                        <form action="approve.php" method="post">
                                            <input type="hidden" name="id" value="<?= escape($entry['id']) ?>">
                                            <button type="submit" class="action-button">批准留言</button>
                                        </form>
                                    <?php endif; ?>
                                    <form action="delete.php" method="post" onsubmit="return confirm('確定要刪除此留言嗎？');">
                                        <input type="hidden" name="id" value="<?= escape($entry['id']) ?>">
                                        <button type="submit" class="action-button" style="background:#dc3545;">刪除留言</button>
                                    </form>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a href="?page=<?= $page - 1 ?>">&laquo; 上一頁</a>
                <?php else: ?>
                    <a class="disabled">&laquo; 上一頁</a>
                <?php endif; ?>

                <?php $totalPages = (int) ceil($totalEntries / $perPage); ?>
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <?php if ($i === $page): ?>
                        <a class="current"><?= $i ?></a>
                    <?php else: ?>
                        <a href="?page=<?= $i ?>"><?= $i ?></a>
                    <?php endif; ?>
                <?php endfor; ?>

                <?php if ($page < $totalPages): ?>
                    <a href="?page=<?= $page + 1 ?>">下一頁 &raquo;</a>
                <?php else: ?>
                    <a class="disabled">下一頁 &raquo;</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
