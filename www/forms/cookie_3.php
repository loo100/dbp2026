<?php
// 檢查是否有透過表單送來的選擇
if (isset($_POST['theme'])) {
    $selected_theme = $_POST['theme'];
    // 存入 Cookie，效期 30 天
    setcookie("theme", $selected_theme, time() + (86400 * 30), "/");
    // 重新導向以立即生效
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// 取得目前的主題，預設為 light
$current_theme = $_COOKIE['theme'] ?? 'light';
?>

<body style="background-color: <?php echo ($current_theme == 'dark') ? '#333' : '#fff'; ?>; 
            color: <?php echo ($current_theme == 'dark') ? '#fff' : '#333'; ?>;">

    <h1>目前的模式：<?php echo strtoupper($current_theme); ?></h1>

    <form method="POST">
        <button type="submit" name="theme" value="light">淺色模式</button>
        <button type="submit" name="theme" value="dark">深色模式</button>
    </form>
</body>