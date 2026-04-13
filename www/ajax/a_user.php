<?php
header('Content-Type: application/json; charset=utf-8');

// 取得 POST 資料
$input = json_decode(file_get_contents('php://input'), true);
$userId = intval($input['id'] ?? 0);

// 模擬資料庫
$users = [
    1 => ['name' => '李明', 'email' => 'liming@example.com', 'city' => '台北'],
    2 => ['name' => '王芳', 'email' => 'wangfang@example.com', 'city' => '台中'],
    3 => ['name' => '張三', 'email' => 'zhangsan@example.com', 'city' => '高雄']
];

$result = [
    'success' => false,
    'name' => '',
    'email' => '',
    'city' => ''
];

if (isset($users[$userId])) {
    $result['success'] = true;
    $result['name'] = $users[$userId]['name'];
    $result['email'] = $users[$userId]['email'];
    $result['city'] = $users[$userId]['city'];
}

echo json_encode($result);
?>