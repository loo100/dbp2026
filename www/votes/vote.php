<?php
require 'db_config.php';

// 檢查是否為 POST 請求
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: index.php");
    exit();
}

// 接收投票資料
$candidate_id = $_POST['candidate_id'] ?? null;
$voter_name = $_COOKIE['voter_name'] ?? '';

// 驗證必填資料
if (empty($candidate_id) || empty($voter_name)) {
    header("Location: index.php?error=invalid_data");
    exit();
}

try {
    // 檢查候選項目是否存在
    $check_candidate = $pdo->prepare("SELECT id FROM candidates WHERE id = ?");
    $check_candidate->execute([$candidate_id]);
    
    if ($check_candidate->rowCount() == 0) {
        die("錯誤：該候選項目不存在！<br><a href='index.php'>返回投票</a>");
    }

    // 檢查是否已投過任一項目
    $check_vote = $pdo->prepare("SELECT id FROM votes WHERE voter_name = ? LIMIT 1");
    $check_vote->execute([$voter_name]);
    
    if ($check_vote->rowCount() > 0) {
        header("Location: index.php?error=already_voted");
        exit();
    }

    // 記錄投票
    $insert_vote = $pdo->prepare("INSERT INTO votes (candidate_id, voter_name) VALUES (?, ?)");
    $insert_vote->execute([$candidate_id, $voter_name]);

    // 跳轉到投票成功頁面
    header("Location: vote_success.php?candidate_id=" . urlencode($candidate_id));
    exit();

} catch (PDOException $e) {
    echo "投票失敗！<br>";
    echo "錯誤訊息：" . $e->getMessage() . "<br>";
    echo "<a href='index.php'>返回投票</a>";
}
?>
