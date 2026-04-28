<?php
session_start();
header('Content-Type: text/html; charset=utf-8');

require 'db_config.php';

if (empty($_SESSION['is_admin'])) {
    die('僅限管理員操作。');
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Invalid request method.');
}

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
if ($id === false || $id === null) {
    die('Invalid entry ID.');
}

try {
    $stmt = $pdo->prepare('DELETE FROM guestbook WHERE id = :id');
    $stmt->execute([':id' => $id]);

    header('Location: index.php');
    exit;
} catch (PDOException $e) {
    die('Error deleting guestbook entry: ' . $e->getMessage());
}
