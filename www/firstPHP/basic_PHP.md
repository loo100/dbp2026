# PHP 基礎概念

PHP 是一門專門為 Web 開發設計的後端語言。它的特點是可以直接嵌入在 HTML 之中。

以下為初學者必須掌握的五大核心語法，另有幾個可直接執行的範例。

## PHP 核心語法教學

### 1. 宣告與標籤

所有的 PHP 程式碼都必須寫在 `<?php ... ?>` 標籤之間。如果檔案純粹是 PHP 邏輯（沒有 HTML），通常結尾的 `?>` 可以省略。

### 2. 變數 (Variables)

在 PHP 中，變數必須以 `$` 符號開頭。它是弱型別語言，你不需要預先宣告變數類型（如 string 或 int）。

```php
$name = "Gemini";  // 字串
$age = 25;         // 整數
```

### 3. 資料輸出 (Output)

最常用的是 `echo`，它可以將字串或變數內容輸出到網頁上。

### 4. 陣列 (Arrays)

在處理資料庫數據時，陣列非常重要。PHP 的關聯陣列（Associative Arrays）類似於其他語言的 JSON 或 Dictionary。

```php
$user = ["name" => "夥伴", "role" => "開發者"];
echo $user["name"]; // 輸出：夥伴
```

### 5. 邏輯控制 (Control Structures)

包含條件判斷 `if...else` 以及迴圈 `foreach`。在全端開發中，`foreach` 常用來把資料庫結果轉成表格。

---

同學可利用 W3School / PHP 進行教學
