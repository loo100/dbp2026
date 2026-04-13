# 簡易討論區應用

一個簡單的討論區系統，使用 PHP + MySQL，支援發表討論與回應功能。

## 功能說明

- **index.php** - 顯示所有討論標題，提供發表新討論的表單
- **post.php** - 處理新討論的提交
- **show_news.php** - 顯示討論內容與所有回應，提供回應表單
- **post_reply.php** - 處理回應的提交
- **db_config.php** - 資料庫連接配置
- **news.sql** - 資料庫結構與範例資料

## 資料庫設置

### 1. 建立資料庫與資料表

使用 phpMyAdmin 或命令列執行 `news.sql` 檔案：

```sql

-- Main news table
CREATE TABLE news (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    content TEXT NOT NULL,
    author VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Replies table
CREATE TABLE replies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    news_id INT NOT NULL,
    content TEXT NOT NULL,
    author VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (news_id) REFERENCES news(id) ON DELETE CASCADE
);
```

### 2. 資料表結構

#### news 表（討論主題）
- `id` - 主鍵
- `title` - 討論標題
- `content` - 討論內容
- `author` - 作者名稱
- `created_at` - 建立時間

#### replies 表（回應）
- `id` - 主鍵
- `news_id` - 關聯的討論 ID
- `content` - 回應內容
- `author` - 作者名稱
- `created_at` - 建立時間

### 3. 修改資料庫連接設定

編輯 `db_config.php`：

```php
$host = 'localhost';
$db = 'newsgroup';
$user = 'root';
$password = '';
```

## 執行方式

1. 開啟瀏覽器，存取：`http://localhost/newsGroup/index.php`
2. 在首頁可以：
   - 查看所有討論主題
   - 發表新討論
3. 點擊討論標題進入討論頁面：
   - 查看完整內容
   - 查看所有回應
   - 發表回應

## 檔案結構

```
newsGroup/
├── index.php          (首頁 - 討論列表)
├── post.php           (處理新討論提交)
├── show_news.php      (顯示討論內容與回應)
├── post_reply.php     (處理回應提交)
├── db_config.php      (資料庫配置)
├── news.sql           (資料庫結構)
└── README.md          (說明文件)
```

## 核心功能

### 1. 討論列表（index.php）
- 顯示所有討論標題
- 顯示作者與發表時間
- 顯示回應數量
- 提供發表新討論表單

### 2. 發表討論（post.php）
- 驗證必填欄位
- 限制輸入長度
- 插入資料庫
- 重新導向至首頁

### 3. 顯示討論（show_news.php）
- 顯示討論完整內容
- 顯示所有回應
- 提供回應表單
- 顯示回應數量

### 4. 發表回應（post_reply.php）
- 驗證討論是否存在
- 驗證必填欄位
- 插入回應資料
- 重新導向回討論頁面

## 技術重點

### PDO 查詢（含 JOIN）

```php
$stmt = $pdo->query('
    SELECT n.id, n.title, n.author, n.created_at,
           COUNT(r.id) as reply_count
    FROM news n
    LEFT JOIN replies r ON n.id = r.news_id
    GROUP BY n.id
    ORDER BY n.created_at DESC
');
```

### 參數化查詢（防 SQL Injection）

```php
$stmt = $pdo->prepare('INSERT INTO news (title, content, author) VALUES (?, ?, ?)');
$stmt->execute([$title, $content, $author]);
```

### XSS 防護

```php
function escape($value) {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
```

## 延伸練習

1. 新增「編輯討論」功能
2. 新增「刪除討論/回應」功能
3. 新增「分頁」功能
4. 新增「搜尋」功能
5. 新增「使用者系統」（登入認證）
6. 新增「點讚/按讚」功能
7. 新增「標籤分類」功能
8. 新增「富文本編輯器」

## 注意事項

- 所有輸出都使用 `htmlspecialchars()` 防止 XSS
- 使用 PDO 參數化查詢防止 SQL Injection
- 輸入長度已限制（author 100 字、title 200 字、content 10000 字）
- 使用 `ON DELETE CASCADE` 確保刪除討論時自動刪除相關回應
