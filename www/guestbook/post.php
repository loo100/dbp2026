<?php
session_start();
header('Content-Type: text/html; charset=utf-8');

require 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Invalid request method.');
}

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$message = trim((string) ($_POST['message'] ?? ''));

$errors = [];
if ($message === '') {
    $errors[] = '留言內容為必填欄位。';
}
if (mb_strlen($message, 'UTF-8') > 5000) {
    $errors[] = '留言最多 5000 個字元。';
}

if (!empty($errors)) {
    foreach ($errors as $error) {
        echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8') . '<br>';
    }
    echo '<p><a href="index.php">返回留言板</a></p>';
    exit;
}

try {
    $stmt = $pdo->prepare('INSERT INTO guestbook (user_id, name, message, status) VALUES (?, ?, ?, ?)');
    $stmt->execute([$_SESSION['user_id'], $_SESSION['nickname'], $message, 'pending']);

    header('Location: index.php');
    exit;
} catch (PDOException $e) {
    die('Error inserting guestbook entry: ' . $e->getMessage());
}
