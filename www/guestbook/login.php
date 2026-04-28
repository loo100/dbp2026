<?php
session_start();
header('Content-Type: text/html; charset=utf-8');

require 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim((string) ($_POST['username'] ?? ''));
    $password = trim((string) ($_POST['password'] ?? ''));

    $errors = [];
    if ($username === '') {
        $errors[] = '帳號為必填欄位。';
    }
    if ($password === '') {
        $errors[] = '密碼為必填欄位。';
    }

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare('SELECT id, username, nickname, favorite_color, avatar, is_admin, password FROM users WHERE username = ?');
            $stmt->execute([$username]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['nickname'] = $user['nickname'];
                $_SESSION['favorite_color'] = $user['favorite_color'];
                $_SESSION['avatar'] = $user['avatar'];
                $_SESSION['is_admin'] = (int) $user['is_admin'];
                header('Location: index.php');
                exit;
            }

            $errors[] = '帳號或密碼錯誤。';
        } catch (PDOException $e) {
            $errors[] = '登入失敗：' . $e->getMessage();
        }
    }
}

$registered = isset($_GET['registered']) && $_GET['registered'] == '1';
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="utf-8">
    <title>登入</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        form { max-width: 400px; margin: auto; }
        input { display: block; width: 100%; margin-bottom: 10px; padding: 8px; }
        button { padding: 10px; background: #007bff; color: white; border: none; cursor: pointer; width: 100%; }
        .error { color: red; margin-bottom: 15px; }
        .success { color: green; margin-bottom: 15px; }
    </style>
</head>
<body>
    <h1>登入</h1>
    <?php if ($registered): ?>
        <div class="success">註冊成功！請登入。</div>
    <?php endif; ?>
    <?php if (!empty($errors)): ?>
        <div class="error">
            <?php foreach ($errors as $error): ?>
                <p><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <form method="post">
        <input type="text" name="username" placeholder="帳號" required>
        <input type="password" name="password" placeholder="密碼" required>
        <button type="submit">登入</button>
    </form>
    <p><a href="register.php">沒有帳號？註冊</a></p>
    <p><a href="index.php">返回留言板</a></p>
</body>
</html>