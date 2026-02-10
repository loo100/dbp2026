<?php
// 1. 刪除 Cookie：使用 setcookie() 函數，將 Cookie 的值設為空字串，並將到期時間設為過去的時間

// 將到期時間設為一小時前，瀏覽器會立即移除它
setcookie("username", "", time() - 3600, "/");
echo "Cookie 已刪除。";
?>
