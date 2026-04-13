<?php
// Insert guestbook entry into database

header('Content-Type: text/html; charset=utf-8');

require 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Invalid request method.');
}

$name = isset($_POST['name']) ? $_POST['name'] : '';
$message = isset($_POST['message']) ? $_POST['message'] : '';

// Basic validation
if (empty($name) || empty($message)) {
    die('Name and message are required.');
}

// Limit input length
$name = substr($name, 0, 100);
$message = substr($message, 0, 5000);

try {
    $stmt = $pdo->prepare('INSERT INTO guestbook (name, message) VALUES (?, ?)');
    $stmt->execute([$name, $message]);

    // Redirect back to index.php
    header('Location: index.php');
    exit;
} catch (PDOException $e) {
    die('Error inserting guestbook entry: ' . $e->getMessage());
}
