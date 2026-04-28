# 留言板應用

一個簡單基礎的留言板應用，使用 PHP + MySQL + PDO。

## 功能說明

- **index.php** - 讀取並顯示所有留言，提供表單輸入新留言，支援分頁、留言數統計與管理操作
- **post.php** - 接收表單提交，將留言寫入資料庫，留言預設為待審核
- **delete.php** - 刪除留言功能
- **approve.php** - 管理員批准留言，將狀態改為已審核
- **db_config.php** - 資料庫連接配置（PDO）
- **setup.php** - 自動建立 `test_db` 與 `guestbook` 資料表，並支援欄位升級

## 資料庫設置

### 1. 建立資料庫

使用 phpMyAdmin 或命令列建立資料庫 `test_db`：

```sql
CREATE DATABASE test_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE test_db;
```

### 2. 建立資料表

執行以下 SQL 建立 `guestbook` 表：

```sql
CREATE TABLE guestbook (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    message TEXT NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

或使用 `guestbook.sql` 檔案進行匯入。

### 3. 修改資料庫連接設定

編輯 `db_config.php`，設定以下參數：

```php
$host = 'localhost';      // 資料庫伺服器
$db = 'test_db';           // 資料庫名稱
$user = 'root';            // 資料庫使用者
$password = '';            // 資料庫密碼
```

或可使用環境變數：

- `DB_HOST`
- `DB_NAME`
- `DB_USER`
- `DB_PASSWORD`

### 4. 自動建立資料庫與資料表

如果你還沒有建立 `test_db`，可以直接開啟瀏覽器執行：

```text
http://localhost/U1333055/dbp2026/www/guestbook/setup.php
```

或視你的 Laragon 網站根目錄調整路徑。此頁面會自動建立 `test_db` 和 `guestbook` 資料表。

> 建立完成後，請移除或保護 `setup.php`，避免未授權使用。

## 執行方式

1. 開啟瀏覽器，存取：`http://localhost/guestbook/index.php`
2. 輸入姓名與留言內容
3. 點擊「提交留言」
4. 新留言會顯示在頁面上方

## 技術重點

### PDO 連接

```php
$pdo = new PDO($dsn, $user, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
```

### 查詢留言

```php
$stmt = $pdo->query('SELECT ... FROM guestbook ORDER BY created_at DESC');
$entries = $stmt->fetchAll(PDO::FETCH_ASSOC);
```

### 插入留言（參數化查詢）

```php
$stmt = $pdo->prepare('INSERT INTO guestbook (name, message) VALUES (?, ?)');
$stmt->execute([$name, $message]);
```

## 檔案結構

```
guestbook/
├── index.php          (讀取和顯示留言，分頁與管理操作)
├── post.php           (寫入留言到資料庫，留言預設為待審核)
├── delete.php         (刪除留言功能)
├── approve.php        (批准留言功能)
├── setup.php          (自動建立資料庫與資料表)
├── db_config.php      (資料庫連接配置)
├── guestbook.sql      (建立資料表的 SQL)
└── README.md          (說明文件)
```

## 延伸練習

1. 新增「刪除留言」功能（新增 delete.php）
2. 新增「管理員審核」功能（新增 status 欄位）
3. 新增「分頁」功能（LIMIT 查詢）
4. 新增「留言計數」統計
5. 新增表單驗證與防止 XSS 攻擊

## 注意事項

- 所有輸出都使用 `htmlspecialchars()` 防止 XSS
- 使用 PDO 參數化查詢防止 SQL Injection
- 輸入長度已限制（name 100 字、message 5000 字）
