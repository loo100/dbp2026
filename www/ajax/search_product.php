<?php
header('Content-Type: application/json; charset=utf-8');

$input = json_decode(file_get_contents('php://input'), true);
$query = strtolower($input['query'] ?? '');

// 模擬產品資料庫
$products = [
    ['name' => 'iPhone 15', 'price' => 25999],
    ['name' => 'iPad Pro', 'price' => 19999],
    ['name' => 'MacBook Pro', 'price' => 49999],
    ['name' => 'AirPods Pro', 'price' => 5990],
    ['name' => 'Apple Watch', 'price' => 12900]
];

// 搜尋匹配的產品
$results = array_filter($products, function ($product) use ($query) {
    return strpos(strtolower($product['name']), $query) !== false;
});

echo json_encode(['results' => array_values($results)]);
?>