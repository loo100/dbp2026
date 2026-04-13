<?php
// 設定投票者 Cookie，有效期為 30 天
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $voter_name = $_POST['voter_name'] ?? '';
    
    if (!empty($voter_name)) {
        // 長度驗證
        if (strlen($voter_name) > 50) {
            header("Location: index.php?error=name_too_long");
            exit();
        }
        
        // 設定 Cookie
        setcookie('voter_name', $voter_name, time() + (30 * 24 * 60 * 60), '/votes/');
        
        // 重導回投票頁面
        header("Location: index.php");
        exit();
    }
}

header("Location: index.php");
exit();
?>
