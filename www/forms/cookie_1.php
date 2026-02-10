<?php
// 1. 設定 Cookie：名稱為 "username"，值為 "Alex"，86400 秒 (1天) 後過期
setcookie("username", "Alex", time() + 86400, "/", "", false, true);
?>
<html>
<body>
<?php
// 2. 讀取 Cookie：使用超全域變數 $_COOKIE 來存取 Cookie 的值
    if (isset($_COOKIE["username"])) {
        echo "歡迎回來，" . htmlspecialchars($_COOKIE["username"]) . "！";
    } else {
        echo "您好，新朋友！";
    }
?>
</body>
</html>