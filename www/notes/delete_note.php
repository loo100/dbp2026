<?php
session_start();
if (!isset($_SESSION['user_id'])) { 
    header("Location: login.php"); 
    exit; 
}

require 'db.php';

$user_id = $_SESSION['user_id'];
$note_id = $_GET['id'] ?? null;

if (!$note_id) {
    header("Location: notes_with_image.php");
    exit;
}

try {
    // 驗證筆記是否屬於當前使用者
    $stmt = $pdo->prepare("SELECT image_path FROM notes WHERE id = ? AND user_id = ?");
    $stmt->execute([$note_id, $user_id]);
    $note = $stmt->fetch();

    if (!$note) {
        header("Location: notes_with_image.php");
        exit;
    }

    // 刪除圖片檔案
    if ($note['image_path'] && file_exists($note['image_path'])) {
        unlink($note['image_path']);
    }

    // 刪除筆記
    $delete_stmt = $pdo->prepare("DELETE FROM notes WHERE id = ? AND user_id = ?");
    $delete_stmt->execute([$note_id, $user_id]);

    header("Location: notes_with_image.php?msg=deleted");
} catch (PDOException $e) {
    die("刪除失敗: " . $e->getMessage());
}
?>
