<?php
header('Content-Type: application/json; charset=utf-8');

$input = json_decode(file_get_contents('php://input'), true);
$field = $input['field'] ?? '';
$value = $input['value'] ?? '';

$result = ['valid' => false, 'message' => ''];

// 驗證帳號
if ($field === 'username') {
    if (strlen($value) < 3) {
        $result['message'] = '帳號長度至少 3 個字';
    } elseif (strlen($value) > 20) {
        $result['message'] = '帳號長度不超過 20 個字';
    } else {
        // 模擬檢查帳號是否已被使用
        $taken_users = ['admin', 'user123', 'test'];
        if (in_array(strtolower($value), $taken_users)) {
            $result['message'] = '帳號已被使用';
        } else {
            $result['valid'] = true;
        }
    }
}

// 驗證信箱
if ($field === 'email') {
    if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
        $result['message'] = '信箱格式不正確';
    } else {
        // 模擬檢查信箱是否已被使用
        $taken_emails = ['test@example.com', 'admin@example.com'];
        if (in_array(strtolower($value), $taken_emails)) {
            $result['message'] = '此信箱已註冊';
        } else {
            $result['valid'] = true;
        }
    }
}

echo json_encode($result);
?>