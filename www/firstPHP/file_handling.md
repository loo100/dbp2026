# PHP 檔案處理範例說明

此範例示範 PHP 在伺服器端進行路徑、資料夾、檔案的存取，以及讀寫文字檔的常用語法。

## 範例檔案

- 範例程式：[firstPHP/file_handling.php](firstPHP/file_handling.php)
- 說明文件：[firstPHP/file_handling.md](firstPHP/file_handling.md)

## 範例重點

### 1. 取得伺服器端路徑

- `__DIR__`：目前 PHP 檔案所在的資料夾路徑
- `getcwd()`：目前工作目錄

### 2. 存取伺服器端資料夾

- `is_dir()`：判斷資料夾是否存在
- `mkdir()`：建立資料夾（可遞迴建立）

### 3. 存取伺服器端檔案

- `file_put_contents()`：寫入文字檔
- `file_exists()`：檢查檔案是否存在

### 4. 讀取伺服器端文字檔

- `file_get_contents()`：讀取文字檔內容

### 5. 列出資料夾內容

- `scandir()`：取得資料夾內的檔案清單

## 程式碼摘要

```php
$baseDir = __DIR__ . DIRECTORY_SEPARATOR . 'file_demo';
$demoFile = $baseDir . DIRECTORY_SEPARATOR . 'notes.txt';

if (!is_dir($baseDir)) {
    mkdir($baseDir, 0775, true);
}

$content = "Hello from PHP file handling\n";
$content .= "Timestamp: " . date('Y-m-d H:i:s') . "\n";

file_put_contents($demoFile, $content, LOCK_EX);  

$fileText = file_get_contents($demoFile);
$files = scandir($baseDir);
```

## 執行方式

1. 將 `file_handling.php` 放在 Web Server 的可存取目錄（已放在 `firstPHP`）。
2. 使用瀏覽器開啟：`http://localhost/firstPHP/file_handling.php`
3. 頁面會顯示：
   - 伺服器端路徑資訊
   - 讀寫檔案的結果
   - 文字檔內容
   - 資料夾檔案清單

## 補充建議

- 若寫入失敗，請確認資料夾權限與 Server 身分是否允許寫入。
- 若部署到正式環境，建議加入錯誤處理與檔名白名單機制。
