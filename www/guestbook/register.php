<?php
session_start();
header('Content-Type: text/html; charset=utf-8');

require 'db_config.php';

$avatars = ['😀', '😎', '🐱', '🐶', '🦊', '🛡️'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim((string) ($_POST['username'] ?? ''));
    $password = trim((string) ($_POST['password'] ?? ''));
    $email = trim((string) ($_POST['email'] ?? ''));
    $nickname = trim((string) ($_POST['nickname'] ?? ''));
    $favorite_color = trim((string) ($_POST['favorite_color'] ?? '#cccccc'));
    $avatar = trim((string) ($_POST['avatar'] ?? '😀'));

    $errors = [];
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
            $isAdmin = ((int) $pdo->query('SELECT COUNT(*) FROM users WHERE is_admin = 1')->fetchColumn() === 0) ? 1 : 0;
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare('INSERT INTO users (username, password, email, nickname, favorite_color, avatar, is_admin) VALUES (?, ?, ?, ?, ?, ?, ?)');
            $stmt->execute([$username, $hashedPassword, $email, $nickname, $favorite_color, $avatar, $isAdmin]);
            header('Location: login.php?registered=1');
            exit;
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $errors[] = '帳號或電子郵件已存在。';
            } else {
                $errors[] = '註冊失敗：' . $e->getMessage();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="utf-8">
    <title>註冊會員</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        form { max-width: 420px; margin: auto; }
        input, select { display: block; width: 100%; margin-bottom: 10px; padding: 8px; box-sizing: border-box; }
        button { padding: 10px; background: #007bff; color: white; border: none; cursor: pointer; width: 100%; }
        .error { color: red; margin-bottom: 15px; }
    </style>
</head>
<body>
    <h1>註冊會員</h1>
    <?php if (!empty($errors)): ?>
        <div class="error">
            <?php foreach ($errors as $error): ?>
                <p><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <form method="post">
        <input type="text" name="username" placeholder="帳號" required maxlength="50" value="<?= htmlspecialchars($username ?? '', ENT_QUOTES, 'UTF-8') ?>">
        <input type="password" name="password" placeholder="密碼（至少6字元）" required>
        <input type="email" name="email" placeholder="電子郵件" required value="<?= htmlspecialchars($email ?? '', ENT_QUOTES, 'UTF-8') ?>">
        <input type="text" name="nickname" placeholder="暱稱" required maxlength="50" value="<?= htmlspecialchars($nickname ?? '', ENT_QUOTES, 'UTF-8') ?>">
        <label>喜歡的顏色：</label>
        <input type="color" name="favorite_color" value="<?= htmlspecialchars($favorite_color ?? '#cccccc', ENT_QUOTES, 'UTF-8') ?>">
        <label>大頭貼：</label>
        <select name="avatar">
            <?php foreach ($avatars as $option): ?>
                <option value="<?= htmlspecialchars($option, ENT_QUOTES, 'UTF-8') ?>" <?= isset($avatar) && $avatar === $option ? 'selected' : '' ?>><?= htmlspecialchars($option, ENT_QUOTES, 'UTF-8') ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">註冊</button>
    </form>
    <p><a href="login.php">已有帳號？登入</a></p>
    <p><a href="index.php">返回留言板</a></p>
</body>
</html>