<?php
// 清除投票者 Cookie
setcookie('voter_name', '', time() - 3600, '/votes/');

// 重導回投票頁面
header("Location: index.php");
exit();
?>
