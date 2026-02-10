# PHP 函式 (Functions) 完整指南

函式是 PHP 的核心特性，用來組織、重用與封裝程式邏輯。本文以實際程式碼示範 PHP 函式的定義、參數傳遞、匿名函式與箭頭函式等概念。

## 範例檔案

- 範例程式：[firstPHP/function_demo.php](firstPHP/function_demo.php)
- 說明文件：[firstPHP/function_demo.md](firstPHP/function_demo.md)

---

## 1. 基本函式定義

最簡單的函式定義方式：

```php
function add($x, $y) {
    return $x + $y;
}

$sum = add(5, 7);  // 結果：12
```

**重點：**
- 使用 `function` 關鍵字宣告
- 參數列在括號內 `($x, $y)`
- 函式內邏輯用 `{}` 包起
- 使用 `return` 回傳結果

---

## 2. 參數傳遞方式

### 2.1 Pass by Value（按值傳遞）

函式內修改參數**不會影響**原變數：

```php
function increaseValue($n) {
    $n = $n + 1;
    return $n;
}

$valueNum = 10;
$afterValue = increaseValue($valueNum);

// 呼叫後：
// $valueNum 仍為 10（未改變）
// $afterValue 為 11
```

函式接收的是變數值的**複製版本**，修改副本不會影響原變數。

### 2.2 Pass by Reference（按參考傳遞）

在參數前加 `&`，函式可直接修改原變數：

```php
function increaseReference(&$n) {
    $n = $n + 1;
    return $n;
}

$refNum = 10;
$afterRef = increaseReference($refNum);

// 呼叫後：
// $refNum 變成 11（已修改）
// $afterRef 為 11
```

函式接收的是原變數的**參考**，修改會直接影響原變數。

**使用時機：**
- 需要函式修改傳入的變數
- 避免複製大型陣列或物件以提高效能

---

## 3. 匿名函式 (Closures)

匿名函式是沒有名稱的函式，可指派給變數或傳遞給其他函式：

```php
$anonymousAdd = function ($x, $y) {
    return $x + $y;
};

$anonSum = $anonymousAdd(3, 4);  // 結果：7
```

**特點：**
- 用 `function` 定義，但無函式名稱
- 指派給變數（需要在結尾加分號 `;`）
- 可以存取外部變數（透過 `use`）

**進階用法：**

```php
$multiplier = 2;
$anonymousDouble = function ($n) use ($multiplier) {
    return $n * $multiplier;
};

$result = $anonymousDouble(5);  // 結果：10
```

---

## 4. 箭頭函式 (Arrow Functions)

PHP 7.4+ 引入，簡化單行函式的寫法：

```php
$multiplier = 2;
$arrowDouble = fn ($n) => $n * $multiplier;

$arrowResult = $arrowDouble(6);  // 結果：12
```

**特點：**
- 使用 `fn` 取代 `function`
- 用 `=>` 指定回傳值（自動 return）
- 自動捕捉外部變數，無需 `use`
- 適合簡短、單一運算的情況

**語法對比：**

| 類型 | 語法 | 自動捕捉 |
|------|------|---------|
| 函式 | `function($x) { return ...; }` | ✗ |
| 匿名函式 | `function($x) use(...) { return ...; }` | ✗ |
| 箭頭函式 | `fn($x) => ...` | ✓ |

---

## 5. 型別提示 (Type Hints)

PHP 7+ 支援在參數與回傳值加入型別提示，提高程式可读性與安全性：

```php
function add(int $x, int $y): int {
    return $x + $y;
}

function greet(string $name): string {
    return "Hello, " . $name;
}
```

**常見型別：**
- `string`、`int`、`float`、`bool`
- `array`、`object`
- `mixed`（任何型別）
- 類名稱（如 `User`、`Manager` 等）

---

## 6. 執行與觀察結果

1. 用瀏覽器開啟：`http://localhost/firstPHP/function_demo.php`
2. 頁面會展示：
   - 基本函式的計算結果
   - Pass by Value 與 Pass by Reference 的差異
   - 匿名函式與箭頭函式的結果

---

## 7. 延伸練習

1. **寫一個計算階乘的函式**
   ```php
   function factorial(int $n): int {
       return $n <= 1 ? 1 : $n * factorial($n - 1);
   }
   ```

2. **寫一個參考傳遞的交換函式**
   ```php
   function swap(&$a, &$b) {
       $temp = $a;
       $a = $b;
       $b = $temp;
   }
   ```

3. **使用箭頭函式搭配 `array_map()`**
   ```php
   $numbers = [1, 2, 3, 4];
   $squared = array_map(fn ($n) => $n ** 2, $numbers);
   // 結果：[1, 4, 9, 16]
   ```

---

## 8. 重要概念總結

| 概念 | 說明 |
|------|------|
| **參數預設值** | `function test($x = 10)` |
| **可變參數** | `function sum(...$numbers)` |
| **參考回傳** | `function &getValue()` |
| **遞迴** | 函式呼叫自己 |
| **高階函式** | 接收或回傳函式的函式 |

---

本範例涵蓋了 PHP 函式的基礎與進階用法，是成為 PHP 開發者必須掌握的技能。
