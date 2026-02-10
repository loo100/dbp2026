# PHP 陣列教學

本教學參考 [firstPHP/array_examples.php](firstPHP/array_examples.php) 的示範，整理 PHP 陣列的常用型態與操作方式。

## 1. 索引陣列 (Indexed Array)

適合儲存有順序的清單資料，索引從 0 開始。

```php
$fruits = ['蘋果', '香蕉', '橙子', '草莓', '葡萄'];

echo $fruits[0]; // 蘋果
echo $fruits[2]; // 橙子
```

常見迭代方式：

```php
foreach ($fruits as $index => $fruit) {
    echo "[$index] => $fruit";
}
```

## 2. 關聯陣列 (Associative Array)

使用自訂 key 儲存資料，方便以語意取值。

```php
$student = [
    'name' => '李明',
    'age' => 20,
    'grade' => 'A',
    'email' => 'liming@example.com',
    'city' => '台北'
];

echo $student['name'];
echo $student['age'];
```

## 3. 多維陣列 (Multidimensional Array)

陣列內含陣列，適合結構化資料。

```php
$students = [
    ['name' => '李明', 'age' => 20, 'scores' => [85, 90, 88]],
    ['name' => '王芳', 'age' => 19, 'scores' => [92, 88, 95]],
    ['name' => '張三', 'age' => 21, 'scores' => [78, 82, 80]]
];

echo $students[0]['name'];
echo $students[1]['scores'][1];
```

## 4. 常用陣列函數

```php
$numbers = [3, 1, 4, 1, 5, 9, 2, 6, 5];

count($numbers);         // 元素個數
array_unique($numbers);  // 移除重複
sort($numbers);          // 排序
rsort($numbers);         // 反向排序
array_sum($numbers);     // 計算總和
array_reverse($numbers); // 反轉
```

## 5. 陣列搜尋與檢查

```php
$colors = ['紅色', '藍色', '綠色', '黃色', '紫色'];

in_array('藍色', $colors);         // 是否存在
array_search('綠色', $colors);     // 找值的位置
array_key_exists(0, $colors);       // 鍵是否存在
```

## 6. 陣列合併與切片

```php
$arr1 = [1, 2, 3];
$arr2 = [4, 5, 6];

$merged = array_merge($arr1, $arr2); // 合併
$slice = array_slice($merged, 1, 3); // 取出部分
```

## 7. 進階迭代：array_map / array_filter

```php
$products = [
    ['name' => '手機', 'price' => 5000],
    ['name' => '平板', 'price' => 3000],
    ['name' => '筆電', 'price' => 8000]
];

$prices = array_column($products, 'price');
$discounted = array_map(function ($price) {
    return $price * 0.9;
}, $prices);

$expensive = array_filter($products, function ($product) {
    return $product['price'] > 3500;
});
```

## 8. 實用範例：購物車計算

```php
$cart = [
    ['item' => '蘋果', 'quantity' => 3, 'price' => 50],
    ['item' => '香蕉', 'quantity' => 2, 'price' => 30],
    ['item' => '橙子', 'quantity' => 5, 'price' => 40]
];

$total = 0;
foreach ($cart as $product) {
    $subtotal = $product['quantity'] * $product['price'];
    $total += $subtotal;
}
```

## 小結

- 索引陣列適合清單資料
- 關聯陣列適合有語意的資料
- 多維陣列可組合更複雜的結構
- 熟悉 `array_*` 相關函數能提升處理效率

如果你要進一步示範 `array_reduce()` 或資料分頁、排序實作，也可以再告訴我。
