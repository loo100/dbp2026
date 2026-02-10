<?php
require 'db_config.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // 1. 尋找是否有對應的 Token
    $stmt = $pdo->prepare("SELECT id FROM members WHERE token = ? AND is_active = 0");
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if ($user) {
        // 2. 更新狀態並清除 Token
        $update = $pdo->prepare("UPDATE members SET is_active = 1, token = NULL WHERE id = ?");
        $update->execute([$user['id']]);
        echo "🎉 帳號啟用成功！現在您可以登入了。";
    } else {
        echo "⚠️ 無效或已過期的啟用碼。";
    }
}
?>