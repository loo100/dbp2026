<?php
session_start();
header('Content-Type: text/html; charset=utf-8');

require 'db_config.php';

if (empty($_SESSION['is_admin'])) {
    die('僅限管理員使用。');
}

$avatars = ['😀', '😎', '🐱', '🐶', '🦊', '🛡️'];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $username = trim((string) ($_POST['username'] ?? ''));
        $password = trim((string) ($_POST['password'] ?? ''));
        $email = trim((string) ($_POST['email'] ?? ''));
        $nickname = trim((string) ($_POST['nickname'] ?? ''));
        $favorite_color = trim((string) ($_POST['favorite_color'] ?? '#cccccc'));
        $avatar = trim((string) ($_POST['avatar'] ?? '😀'));
        $is_admin = isset($_POST['is_admin']) ? 1 : 0;

        if ($username === '') {
            $errors[] = '帳號為必填欄位。';
        }
        if ($password === '') {
            $errors[] = '密碼為必填欄位。';
        }
        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = '請輸入有效的電子郵件地址。';
        }
        if ($nickname === '') {
            $errors[] = '暱稱為必填欄位。';
        }
        if (!preg_match('/^#[0-9A-Fa-f]{6}$/', $favorite_color)) {
            $favorite_color = '#cccccc';
        }
        if (!in_array($avatar, $avatars, true)) {
            $avatar = '😀';
        }
        if (mb_strlen($username, 'UTF-8') > 50) {
            $errors[] = '帳號最多 50 個字元。';
        }
        if (mb_strlen($nickname, 'UTF-8') > 50) {
            $errors[] = '暱稱最多 50 個字元。';
        }
        if (mb_strlen($password, 'UTF-8') < 6) {
            $errors[] = '密碼至少 6 個字元。';
        }

        if (empty($errors)) {
            try {
                $stmt = $pdo->prepare('INSERT INTO users (username, password, email, nickname, favorite_color, avatar, is_admin) VALUES (?, ?, ?, ?, ?, ?, ?)');
                $stmt->execute([$username, password_hash($password, PASSWORD_DEFAULT), $email, $nickname, $favorite_color, $avatar, (int) $is_admin]);
                header('Location: admin.php');
                exit;
            } catch (PDOException $e) {
                if ($e->getCode() == 23000) {
                    $errors[] = '帳號或電子郵件已存在。';
            }
        }
    }

    if ($action === 'delete') {
        $userId = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
        if ($userId === false || $userId === null) {
            $errors[] = '無效的會員 ID。';
        } elseif ($userId === $_SESSION['user_id']) {
            $errors[] = '不能刪除自己。';
        }

        if (empty($errors)) {
            try {
                $stmt = $pdo->prepare('DELETE FROM users WHERE id = ?');
                $stmt->execute([$userId]);
                header('Location: admin.php');
                exit;
            } catch (PDOException $e) {
                $errors[] = '刪除會員失敗：' . $e->getMessage();
            }
        }
    }
}

$users = $pdo->query('SELECT id, username, email, nickname, favorite_color, avatar, is_admin, created_at FROM users ORDER BY created_at DESC')->fetchAll();

function escape($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="utf-8">
    <title>管理員會員管理</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .box { max-width: 900px; margin: auto; }
        form, table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #f4f4f4; }
        input, select { width: 100%; padding: 8px; box-sizing: border-box; margin-bottom: 10px; }
        button { padding: 10px 16px; background: #007bff; color: white; border: none; cursor: pointer; }
        button.delete { background: #dc3545; }
        .error { color: red; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="box">
        <h1>會員管理</h1>
        <p>當前管理員：<?= escape($_SESSION['nickname'] ?? $_SESSION['username'] ?? '管理員') ?>。<a href="index.php">返回留言板</a></p>

        <?php if (!empty($errors)): ?>
            <div class="error">
                <?php foreach ($errors as $error): ?>
                    <p><?= escape($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <h2>新增會員</h2>
        <form method="post">
            <input type="hidden" name="action" value="add">
            <input type="text" name="username" placeholder="帳號" required maxlength="50">
            <input type="password" name="password" placeholder="密碼（至少6字元）" required>
            <input type="email" name="email" placeholder="電子郵件" required>
            <input type="text" name="nickname" placeholder="暱稱" required maxlength="50">
            <label>喜歡的顏色：</label>
            <input type="color" name="favorite_color" value="#cccccc">
            <label>大頭貼：</label>
            <select name="avatar">
                <?php foreach ($avatars as $option): ?>
                    <option value="<?= escape($option) ?>"><?= escape($option) ?></option>
                <?php endforeach; ?>
            </select>
            <label><input type="checkbox" name="is_admin"> 管理員</label>
            <button type="submit">新增會員</button>
        </form>

        <h2>會員列表</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>帳號</th>
                    <th>暱稱</th>
                    <th>電子郵件</th>
                    <th>顏色</th>
                    <th>大頭貼</th>
                    <th>角色</th>
                    <th>建立時間</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= escape($user['id']) ?></td>
                        <td><?= escape($user['username']) ?></td>
                        <td><?= escape($user['nickname']) ?></td>
                        <td><?= escape($user['email']) ?></td>
                        <td style="background: <?= escape($user['favorite_color']) ?>;"><?= escape($user['favorite_color']) ?></td>
                        <td><?= escape($user['avatar']) ?></td>
                        <td><?= $user['is_admin'] ? '管理員' : '一般' ?></td>
                        <td><?= escape($user['created_at']) ?></td>
                        <td>
                            <?php if ($user['id'] !== $_SESSION['user_id']): ?>
                                <form method="post" style="margin:0;">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="user_id" value="<?= escape($user['id']) ?>">
                                    <button type="submit" class="delete" onclick="return confirm('確定刪除此會員？');">刪除</button>
                                </form>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>