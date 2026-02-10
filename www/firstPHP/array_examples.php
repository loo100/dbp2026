<?php
/**
 * PHP 陣列使用示範
 * PHP Array Usage Examples
 */

echo "========================================<br>";
echo "PHP 陣列 (Array) 使用示範<br>";
echo "========================================<br><br>";

// ============================================
// 1. 索引陣列 (Indexed Array)
// ============================================
echo "【1. 索引陣列】<br>";
echo "適合儲存有序的列表資料<br><br>";

$fruits = ['蘋果', '香蕉', '橙子', '草莓', '葡萄'];
echo "定義陣列: \$fruits = ['蘋果', '香蕉', '橙子', '草莓', '葡萄']<br><br>";

// 存取元素
echo "存取第一個元素 (\$fruits[0]): " . $fruits[0] . "<br>";
echo "存取第三個元素 (\$fruits[2]): " . $fruits[2] . "<br>";
echo "存取最後一個元素 (\$fruits[-1]): " . $fruits[count($fruits) - 1] . "<br><br>";

// 列出所有元素
echo "列出所有元素:<br>";
foreach ($fruits as $index => $fruit) {
    echo "  [$index] => {$fruit}<br>";
}
echo "<br>";

// ============================================
// 2. 關聯陣列 (Associative Array)
// ============================================
echo "【2. 關聯陣列】<br>";
echo "使用自定義鍵值儲存資料，便於識別<br><br>";

$student = [
    'name' => '李明',
    'age' => 20,
    'grade' => 'A',
    'email' => 'liming@example.com',
    'city' => '台北'
];
echo "定義陣列: \$student = ['name' => '李明', 'age' => 20, ...]<br><br>";

// 存取元素
echo "學生姓名: " . $student['name'] . "<br>";
echo "學生年齡: " . $student['age'] . "<br>";
echo "學生等級: " . $student['grade'] . "<br>";
echo "學生城市: " . $student['city'] . "<br><br>";

// 列出所有元素
echo "列出所有元素:<br>";
foreach ($student as $key => $value) {
    echo "  {$key} => {$value}<br>";
}
echo "<br>";

// ============================================
// 3. 多維陣列 (Multidimensional Array)
// ============================================
echo "【3. 多維陣列】<br>";
echo "包含多個層級的陣列，適合複雜資料結構<br><br>";

$students = [
    [
        'name' => '李明',
        'age' => 20,
        'scores' => [85, 90, 88]
    ],
    [
        'name' => '王芳',
        'age' => 19,
        'scores' => [92, 88, 95]
    ],
    [
        'name' => '張三',
        'age' => 21,
        'scores' => [78, 82, 80]
    ]
];

echo "定義二維陣列包含學生資訊<br><br>";

// 存取多維元素
echo "第一個學生的姓名: " . $students[0]['name'] . "<br>";
echo "第二個學生的第二個成績: " . $students[1]['scores'][1] . "<br><br>";

// 列出所有學生資訊
echo "列出所有學生資訊:<br>";
foreach ($students as $index => $student) {
    echo "學生 " . ($index + 1) . ":<br>";
    echo "  姓名: " . $student['name'] . "<br>";
    echo "  年齡: " . $student['age'] . "<br>";
    echo "  成績: " . implode(', ', $student['scores']) . "<br>";
    echo "  平均分: " . round(array_sum($student['scores']) / count($student['scores']), 2) . "<br><br>";
}

// ============================================
// 4. 常用的陣列函數
// ============================================
echo "【4. 常用的陣列函數】<br><br>";

$numbers = [3, 1, 4, 1, 5, 9, 2, 6, 5];
echo "原始陣列: " . implode(', ', $numbers) . "<br><br>";

// count() - 計算陣列元素個數
echo "count(\$numbers) - 元素個數: " . count($numbers) . "<br>";

// array_unique() - 移除重複元素
$unique_numbers = array_unique($numbers);
echo "array_unique(\$numbers): " . implode(', ', $unique_numbers) . "<br>";

// sort() - 排序陣列
$sorted = $numbers;
sort($sorted);
echo "sort() - 排序後: " . implode(', ', $sorted) . "<br>";

// rsort() - 反向排序
$reverse_sorted = $numbers;
rsort($reverse_sorted);
echo "rsort() - 反向排序: " . implode(', ', $reverse_sorted) . "<br>";

// array_sum() - 計算總和
echo "array_sum(\$numbers) - 總和: " . array_sum($numbers) . "<br>";

// array_reverse() - 反轉陣列
$reversed = array_reverse($numbers);
echo "array_reverse(\$numbers): " . implode(', ', $reversed) . "<br><br>";

// ============================================
// 5. 陣列搜尋和檢查
// ============================================
echo "【5. 陣列搜尋和檢查】<br><br>";

$colors = ['紅色', '藍色', '綠色', '黃色', '紫色'];
echo "色彩陣列: " . implode(', ', $colors) . "<br><br>";

// in_array() - 檢查值是否存在
if (in_array('藍色', $colors)) {
    echo "in_array('藍色', \$colors) => 存在<br>";
}

// array_search() - 搜尋元素的位置
$position = array_search('綠色', $colors);
echo "array_search('綠色', \$colors) => 位置: {$position}<br>";

// array_key_exists() - 檢查鍵是否存在
if (array_key_exists(0, $colors)) {
    echo "array_key_exists(0, \$colors) => 鍵存在<br>";
};

// ============================================
// 6. 陣列轉換和合併
// ============================================
echo "【6. 陣列轉換和合併】<br><br>";

$arr1 = [1, 2, 3];
$arr2 = [4, 5, 6];
echo "陣列1: " . implode(', ', $arr1) . "<br>";
echo "陣列2: " . implode(', ', $arr2) . "<br><br>";

// array_merge() - 合併陣列
$merged = array_merge($arr1, $arr2);
echo "array_merge() 結果: " . implode(', ', $merged) . "<br>";

// array_slice() - 提取部分陣列
$slice = array_slice($merged, 1, 3);
echo "array_slice(結果, 1, 3): " . implode(', ', $slice) . "<br><br>";

// ============================================
// 7. 陣列迭代 (高級用法)
// ============================================
echo "【7. 陣列迭代 (高級用法)】<br><br>";

$products = [
    ['name' => '手機', 'price' => 5000],
    ['name' => '平板', 'price' => 3000],
    ['name' => '筆電', 'price' => 8000]
];

// array_map() - 對陣列中的每個元素套用函數
echo "使用 array_map() 計算打折 (9折):<br>";
$prices = array_column($products, 'price');
$discounted = array_map(function($price) {
    return $price * 0.9;
}, $prices);

foreach ($products as $index => $product) {
    echo "  {$product['name']}: " . number_format($product['price']) . " => " 
         . number_format($discounted[$index]) . " (省 " 
         . number_format($product['price'] - $discounted[$index]) . ")<br>";
}
echo "<br>";

// array_filter() - 過濾陣列元素
echo "使用 array_filter() 篩選價格 > 3500 的商品:<br>";
$expensive = array_filter($products, function($product) {
    return $product['price'] > 3500;
});

foreach ($expensive as $product) {
    echo "  " . $product['name'] . " (" . number_format($product['price']) . ")<br>";
}
echo "<br>";

// ============================================
// 8. 實用範例：購物車
// ============================================
echo "【8. 實用範例：購物車】<br><br>";

$cart = [
    ['item' => '蘋果', 'quantity' => 3, 'price' => 50],
    ['item' => '香蕉', 'quantity' => 2, 'price' => 30],
    ['item' => '橙子', 'quantity' => 5, 'price' => 40]
];

echo "購物車內容:<br>";
$total = 0;
foreach ($cart as $product) {
    $subtotal = $product['quantity'] * $product['price'];
    $total += $subtotal;
    echo "  {$product['item']} x {$product['quantity']} = " 
         . number_format($subtotal) . " 元<br>";
}
echo "  " . str_repeat('-', 30) . "<br>";
echo "  總金額: " . number_format($total) . " 元<br><br>";

echo "========================================<br>";
echo "PHP 陣列示範完畢<br>";
echo "========================================<br>";
?>
