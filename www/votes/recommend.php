<?php
require 'db_config.php';

// 檢查是否為 POST 請求
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: recommend.html");
    exit();
}

// 接收表單資料
$name = $_POST['name'] ?? '';
$description = $_POST['description'] ?? '';

// 驗證必填欄位
if (empty($name) || empty($description)) {
    die("錯誤：所有欄位都必須填寫！<br><a href='recommend.html'>返回</a>");
}

// 長度驗證
if (strlen($name) > 100) {
    die("錯誤：項目名稱不能超過 100 個字符！<br><a href='recommend.html'>返回</a>");
}

try {
    // 檢查項目名稱是否已存在
    $check_stmt = $pdo->prepare("SELECT id FROM candidates WHERE name = ?");
    $check_stmt->execute([$name]);
    
    if ($check_stmt->rowCount() > 0) {
        die("錯誤：此項目名稱已存在！<br><a href='recommend.html'>返回修改</a>");
    }

    // 插入新的候選項目
    $insert_stmt = $pdo->prepare("INSERT INTO candidates (name, description) VALUES (?, ?)");
    $insert_stmt->execute([$name, $description]);

    // 跳轉到成功頁面
    header("Location: add_success.php?name=" . urlencode($name));
    exit();

} catch (PDOException $e) {
    echo "新增項目失敗！<br>";
    echo "錯誤訊息：" . $e->getMessage() . "<br>";
    echo "<a href='recommend.html'>返回重試</a>";
}
?>
