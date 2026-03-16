# 資料庫程式設計課程 - 完整教學大綱 (16 週)

## 課程概述

本課程教授學生如何使用 HTML、CSS、JavaScript、PHP 及 MySQL 資料庫開發動態網站應用。課程以 Laragon 為開發環境，涵蓋從基礎語法到進階應用（包括 Ajax、PHP GD 繪圖、Laravel 框架介紹）的完整流程。

---
| 週次 | 主題 | 學習重點 | 練習/作業 |
| --- | --- | --- | --- |
| W1 | 課程介紹 | 下載與安裝 Laragon。<br>Laragon 與開發環境設置。<br>了解 Apache 與 PHP 運作原理。<br>了解 GitHub, Github Copilot 運作。 | |
| W2 | 前端基礎 | HTML, CSS, JS，學習引入 UI 框架。<br>設計基本的網站佈局及基礎互動。 | first, todo |
| W3 | PHP 基礎 | 變數、陣列、迴圈、判斷式。<br>HTML 與 PHP 的混寫方式。 | firstPHP |
| W4 | PHP 基礎2 | File, 繪圖 gd。 | gd, pagination |
| W5 | 表單處理 | HTTP GET, POST。接收使用者輸入的資料。上傳檔案。Cookie, Session。 | forms, forms_session |
| W6 | MySQL 資料庫入門 | 使用 Laragon 內建的 HeidiSQL。<br>建立資料庫、資料表 (Table)、欄位型態。 | db_basic |
| W7 | PHP 連接資料庫 (PDO) | 為什麼要用 PDO (安全性)。建立 db.php 連線檔案。<br>Create (寫入資料) 與 Read (顯示列表)。Update (修改資料)。<br>CRUD (新增與讀取) (更新與刪除)。 | db_basic_crud |
| W8 | PHP 進階 | 物件導向概念，composer，寄信 mail。 | mail |
| W9 | 專案應用 1. 留言板/討論區 | 基本資料庫存取練習。 | Guestbook, newsGroup |
| W10 | 專案應用 2. 會員系統 | 註冊(密碼雜湊)；Session 與 Cookie；登入登出；<br>寄信(驗證)；檔案上傳(會員相片)。 | members |
| W11 | 專案應用 3. 投票系統 | 繪製統計圖表。 | votes |
| W12 | 專案應用 4. 購物車 | Cookie 實務應用。 | cart |
| W13 | 專案應用 5. 網路相簿 | 圖片檔案處理及檔案上傳。 | photoAlbum |
| W14 | Ajax 概念介紹 | ES6 Fetch, REST ful 及 POSTMAN。 | ajax |
| W15 | Laravel 開發簡介 | | firstLaravel |
| W16 | 期末專案展示 | 自行擬定題目，功能不少於電子商務網站。 | |


---
## 第 01 週：課程導論 laragon與開發環境架設

**教學目標**：理解 Web 應用的運作原理、安裝並配置 Laragon 開發環境、撰寫第一個 PHP 程式。

**核心內容**：Web 運作流程（瀏覽器 → 伺服器 → 資料庫 → 回傳），Laragon 整合式開發環境特點。

**範例程式碼**：
```php
<?php
echo "<h1>歡迎來到資料庫程式設計課程</h1>";
echo "目前的伺服器時間是：" . date("Y-m-d H:i:s");
?>
```

---

## 第 02 週：前端基礎

**教學目標**：掌握 HTML5 語意化標籤、設計與實現表單結構、理解表單與 PHP 的互動。

**核心內容**：語意化標籤（header、nav、main、article、footer）、表單元素（input、textarea、select、radio、checkbox）。

**教學目標**：掌握 CSS 選擇器與優先級、理解 Box Model 與 Flexbox 佈局、實現響應式設計基礎。

**核心內容**：Flexbox 佈局（display: flex、justify-content、align-items、flex-direction）、響應式設計（@media 查詢）。

**教學目標**：掌握 JavaScript 變數與資料型別、理解流程控制、實現 DOM 操作與表單驗證。

**核心內容**：DOM 操作（getElementById、querySelector、addEventListener）、表單驗證。

---

## 第 03 週：PHP 基礎語法

**教學目標**：掌握 PHP 變數、陣列、函數、理解 GET 與 POST 表單資料處理。

**核心內容**：表單資料接收（$_GET、$_POST、$_REQUEST）、資料驗證（isset、empty、is_numeric）。

**範例程式碼**：
```php
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    
    if (!empty($username) && !empty($password)) {
        echo "歡迎，" . htmlspecialchars($username);
    } else {
        echo "請填寫所有欄位";
    }
}
?>
```

---
## 第 04 週：PHP 基礎2

**教學目標**：掌握 PHP 檔案、繪圖。

**核心內容**：檔案管理及處理、繪圖功能。

物件導向部分稍後與 寄信單元一起介紹。

---
## 第 05 週：表單處裡


**教學目標**：學習如何在網頁之間交換訊息。這一單元是網頁互動的核心，使用者經由表單將訊息或需求傳遞給服務端。


**核心內容**：表單輸入，HTTP GET, POST。接收使用者輸入的資料。
上傳檔案。 Cookie。Session。


---
## 第 06 週：MySQL 資料庫基礎

**教學目標**：掌握 SQL 基本語法 (CRUD)、使用 phpMyAdmin 管理資料庫、PHP 與資料庫介面。

**核心內容**：SQL 語句（CREATE TABLE、INSERT、SELECT、UPDATE、DELETE）。

**範例程式碼**：
```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (username, password, email) 
VALUES ('john', 'hashed_password', 'john@example.com');

SELECT * FROM users WHERE username = 'john';
```

---

## 第 07 週：PHP 與資料庫連線 (PDO)(CRUD)

**教學目標**：使用 PDO 進行安全連線、實現資料讀取與顯示、防止 SQL Injection 攻擊。

**核心內容**：PDO 連線、Prepared Statements、資料顯示。

**範例程式碼**：
```php
<?php
$host = 'localhost';
$db = 'course_db';
$user = 'root';
$pass = '';
$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $user, $pass);
} catch (PDOException $e) {
    die("連線失敗：" . $e->getMessage());
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$_POST['username']]);
$user = $stmt->fetch();
?>
```
---
## 第 08 週：PHP 物件導向與寄信套件
**教學目標**： PHP 物件導向程式設計。套件管理 composer 。程式寄信。

**核心內容**： 物件導向的類別設計、PHP 套件概念與管理、套件範例：PHP Mailer。透過 Google mail service 寄信。


---

## 第 09 週：專案應用 1 - 留言板/討論區

**任務說明**：建立一個簡單的留言板系統，練習基本的資料庫存取 (CRUD)。

**功能需求**：顯示所有留言、新增留言、資料驗證、安全防護（htmlspecialchars）。

**資料庫結構**：
```sql
CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

---

## 第 10 週：專案應用 2. 會員系統 - 註冊與密碼安全

**教學目標**：實現使用者註冊功能、使用 password_hash() 安全儲存密碼、理解 Session 與 Cookie 機制。

**核心內容**：密碼雜湊（password_hash、password_verify）、Session 管理（session_start、$_SESSION）。

**範例程式碼**：
```php
<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->execute([$username, $hashed_password]);
    
    $_SESSION['user_id'] = $pdo->lastInsertId();
    header("Location: dashboard.php");
}
?>
```

**教學目標**：實現登入與登出功能、使用 PHPMailer 發送驗證信、處理檔案上傳。

**核心內容**：登入驗證（password_verify）、寄信（PHPMailer/mail()）、檔案上傳（$_FILES、move_uploaded_file）。

**範例程式碼**：
```php
<?php
$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch();

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    echo "登入成功";
} else {
    echo "帳號或密碼錯誤";
}

if ($_FILES['avatar']['size'] > 0) {
    $upload_dir = 'uploads/avatars/';
    $filename = uniqid() . '_' . $_FILES['avatar']['name'];
    move_uploaded_file($_FILES['avatar']['tmp_name'], $upload_dir . $filename);
}
?>
```

**作業 2：會員系統**：完整實現包含註冊、登入、寄信驗證及頭像上傳的會員系統。

---

## 第 11 週：專案應用 3. PHP GD 繪圖與投票系統

**教學目標**：掌握 PHP GD 函式庫基本用法、動態產生圖表、實現投票系統。

**核心內容**：PHP GD 基本函數（imagecreate、imagecolorallocate、imagestring、imagepng）、動態圖表。

**範例程式碼**：
```php
<?php
header("Content-type: image/png");

$image = imagecreate(400, 300);
$background = imagecolorallocate($image, 255, 255, 255);
$bar_color = imagecolorallocate($image, 52, 152, 219);

$data = [10, 20, 15, 25];
$bar_width = 80;
$start_x = 50;

for ($i = 0; $i < count($data); $i++) {
    $x = $start_x + ($i * 80);
    $height = $data[$i] * 5;
    imagefilledrectangle($image, $x, 250 - $height, $x + $bar_width, 250, $bar_color);
}

imagepng($image);
imagedestroy($image);
?>
```

**作業 3：投票系統**：建立線上投票系統，並使用 PHP GD 動態產生投票結果的統計圖表。

---



## 第 12 週：專案應用 4. 電子商務基礎 - 購物車實現

**教學目標**：使用 Cookie 暫存購物清單、實現購物車的增刪改查功能、計算購物車總金額。

**核心內容**：Cookie 使用（setcookie、$_COOKIE）、購物車邏輯。

**範例程式碼**：
```php
<?php
if (!isset($_COOKIE['cart'])) {
    $cart = [];
} else {
    $cart = unserialize($_COOKIE['cart']);
}

if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : 1;
    
    if (isset($cart[$product_id])) {
        $cart[$product_id] += $quantity;
    } else {
        $cart[$product_id] = $quantity;
    }
    
    setcookie('cart', serialize($cart), time() + 3600 * 24 * 30);
}

$total = 0;
foreach ($cart as $product_id => $quantity) {
    $stmt = $pdo->prepare("SELECT price FROM products WHERE id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch();
    $total += $product['price'] * $quantity;
}
?>
```

**作業 4：購物車**：實現完整的購物車功能，包括加入、修改數量、刪除商品及計算總金額。

---

## 第 13 週：專案應用 5. 檔案處理進階 - 網路相簿

**教學目標**：實現圖片檔案上傳與驗證、使用 PHP GD 自動產生縮圖、批次處理多個檔案。

**核心內容**：檔案驗證、縮圖產生（imagecopyresampled）。

**範例程式碼**：
```php
<?php
if ($_FILES['image']['size'] > 0) {
    $filename = uniqid() . '.jpg';
    $upload_path = 'uploads/images/' . $filename;
    
    move_uploaded_file($_FILES['image']['tmp_name'], $upload_path);
    
    $image = imagecreatefromjpeg($upload_path);
    $width = imagesx($image);
    $height = imagesy($image);
    
    $thumb_width = 150;
    $thumb_height = ($height / $width) * $thumb_width;
    
    $thumb = imagecreatetruecolor($thumb_width, $thumb_height);
    imagecopyresampled($thumb, $image, 0, 0, 0, 0, $thumb_width, $thumb_height, $width, $height);
    
    imagejpeg($thumb, 'uploads/thumbs/' . $filename);
    imagedestroy($image);
    imagedestroy($thumb);
}
?>
```

**作業 5：網路相簿**：建立個人相簿系統，支援批次上傳與自動縮圖產生。

---
## 第 14 週：Ajax 與非同步請求

**教學目標**：理解 Ajax 的概念與應用、使用 Fetch API 進行非同步請求、處理 JSON 資料。

**核心內容**：Fetch API、JSON 處理（JSON.stringify、JSON.parse）。

**範例程式碼**：
```javascript
fetch('api/get_messages.php')
    .then(response => response.json())
    .then(data => {
        document.getElementById('messages').innerHTML = data.messages;
    })
    .catch(error => console.error('Error:', error));

fetch('api/add_message.php', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json'
    },
    body: JSON.stringify({
        name: 'John',
        content: 'Hello World'
    })
})
.then(response => response.json())
.then(data => console.log(data));
```

**PHP 端**：
```php
<?php
header('Content-Type: application/json');

$stmt = $pdo->query("SELECT * FROM messages ORDER BY created_at DESC");
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(['messages' => $messages]);
?>
```

---
## 第 15 週：Laravel 框架介紹

**教學目標**：理解 MVC 架構、掌握 Laravel 基本概念、使用 Eloquent ORM 進行資料庫操作。

**核心內容**：MVC 架構、Laravel 特點（路由、ORM、認證系統、遷移工具）。

**範例程式碼**：
```php
// routes/web.php
Route::get('/users', [UserController::class, 'index']);
Route::post('/users', [UserController::class, 'store']);

// app/Models/User.php
class User extends Model {
    protected $fillable = ['name', 'email', 'password'];
}

// app/Http/Controllers/UserController.php
class UserController extends Controller {
    public function index() {
        $users = User::all();
        return view('users.index', ['users' => $users]);
    }
}
```

---

## 第 16 週：期末專案 - 電子商務網站開發或其他

**專案概述**：整合本學期所學技術，開發一個功能完整的電子商務平台。

**核心功能模組**：
* **會員模組**：註冊、登入、個人資料修改、訂單查詢
* **商品模組**：分類瀏覽、關鍵字搜尋、商品詳情頁
* **購物模組**：購物車管理、結帳流程（模擬）
* **管理後台**：商品上架/下架、訂單狀態管理、銷售統計圖表
* **進階技術**：Ajax 無重新整理購物車、PHP GD 訂單報表、Laravel 框架應用

**評分標準**：功能完整性 (40%)、程式碼結構與安全性 (30%)、使用者介面設計 (20%)、創意與額外功能 (10%)

---

## 技術棧總結

| 技術 | 用途 | 學習週次 |
|:---|:---|:---|
| HTML5 | 網頁結構 | 第 02 週 |
| CSS3 | 網頁美化與佈局 | 第 03 週 |
| JavaScript | 客戶端互動與驗證 | 第 04 週 |
| PHP | 伺服器端邏輯 | 第 05 週 |
| MySQL | 資料庫管理 | 第 06 週 |
| PDO | 資料庫連線 | 第 07 週 |
| Ajax/Fetch | 非同步請求 | 第 08 週 |
| Cookie/Session | 狀態管理 | 第 09-10 週 |
| PHP GD | 動態圖表生成 | 第 11 週 |
| Laravel | 現代框架 | 第 15 週 |

---

## 作業與評分

**小型作業 (5個)**：留言板、會員系統、投票系統、購物車、網路相簿

**期末作業**：電子商務網站整合所有功能的完整平台
