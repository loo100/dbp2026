<?php
header('Content-Type: application/json; charset=utf-8');

$input = json_decode(file_get_contents('php://input'), true);
$page = intval($input['page'] ?? 1);

// 模擬文章資料庫
$allPosts = [];
for ($i = 1; $i <= 50; $i++) {
    $allPosts[] = [
        'title' => "文章 $i",
        'content' => "這是文章 $i 的內容摘要..."
    ];
}

// 分頁：每頁 5 篇
$perPage = 5;
$start = ($page - 1) * $perPage;
$posts = array_slice($allPosts, $start, $perPage);

echo json_encode(['posts' => $posts]);
?>