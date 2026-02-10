# 會員註冊功能實作教學

實作一個簡單的「會員註冊」功能。為了確保安全，我們會使用 PDO 預處理語句 (Prepared Statements)，這是防止 SQL 注入攻擊的標準做法。

---

## 1. 準備資料庫表 (SQL)

請先打開 phpmyadmin，在 `test_db` 資料庫中執行以下 SQL 指令來建立 `members` 表：

```sql
CREATE TABLE members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL, -- 密碼通常會加密，所以長度設長一點
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

---

## 2. 建立註冊程式碼 (`register.php`)

### 關鍵技術點解析

#### 1️⃣ `$_SERVER["REQUEST_METHOD"] == "POST"`

這是一種比 `isset($_POST['submit'])` 更專業的寫法，用來判斷當前頁面是否是透過表單「送出」而觸發的。

#### 2️⃣ 預處理語句 (Prepared Statements)

注意到我們在 SQL 中寫了 `VALUES (?, ?, ?)`？

- 這些問號是「**佔位符**」
- 我們**不直接**把變數塞進 SQL 字串
- 而是透過 `$stmt->execute([...])` 把值傳進去

**為什麼？**  
這樣可以防止駭客在輸入框寫下惡意代碼（例如 `'; DROP TABLE users; --`）來破壞你的資料庫。

#### 3️⃣ 資料持久化

一旦顯示「註冊成功」，你可以去 phpmyadmin 重新整理一下 `members` 表，你會發現資料已經實實在在地存進硬碟裡了！

---

## 3. 密碼加密與安全實作

> 在現代網頁開發中，「**絕對不要在資料庫存儲明文密碼**」是工程師的首要守則。

PHP 提供了非常強大且易用的 `password_hash()` 函數，它會自動處理「**加鹽 (Salting)**」與「**雜湊 (Hashing)**」，確保即使資料庫被盜，駭客也無法輕易還原出原始密碼。

### 🔒 什麼是密碼雜湊 (Hashing)？

密碼雜湊與普通加密**不同**，它是不可逆的：

- 我們**不「解密」**密碼
- 而是將使用者登入時輸入的密碼**再次進行雜湊**
- 並**比對兩個雜湊值**是否相同

### 加密並存入資料庫

我們修改之前的註冊邏輯。只需變動一行程式碼，就能大幅提升安全性。

#### 使用 `password_hash()` 進行加密

將原本直接拿到的 `$user_pass` 處理如下：

```php
<?php
// 接收原始密碼
$raw_password = $_POST['password'];

// 使用 PASSWORD_DEFAULT 演算法進行雜湊
// 目前 PHP 預設使用的是強大的 BCrypt 演算法
$hashed_password = password_hash($raw_password, PASSWORD_DEFAULT);

// 存入資料庫時，使用的是 $hashed_password
$sql = "INSERT INTO members (username, email, password) VALUES (?, ?, ?)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_name, $user_email, $hashed_password]);
?>
```

---

## 4. 密碼驗證實作

### 🔑 如何驗證密碼？

當使用者登入時，我們使用 `password_verify()` 來檢查輸入的密碼是否與資料庫中的雜湊值匹配。

### 範例：簡易登入驗證邏輯 (`login.php`)

```php
<?php
// 假設我們已經從資料庫根據 email 抓到了該使用者的資料
$user_from_db = [
    "username" => "Alex",
    "password" => '$2y$10$8K1X...' // 這是從資料庫抓出來的長長雜湊字串
];

$input_password = $_POST['password']; // 使用者在登入表單輸入的密碼

// 驗證密碼
if (password_verify($input_password, $user_from_db['password'])) {
    echo "✅ 登入成功！";
} else {
    echo "❌ 密碼錯誤，請再試一次。";
}
?>
```

---

## 5. 為什麼要用 `password_hash()`？

### ✅ 自動加鹽 (Salting)

即使兩個使用者設定一樣的密碼（例如 `123456`），產生的雜湊值也會**完全不同**。這能防範「**彩虹表 (Rainbow Table)**」攻擊。

### ✅ 安全性升級

`PASSWORD_DEFAULT` 會隨著 PHP 版本的更新，自動切換到當前公認最強的演算法（如 Argon2id），開發者**不需要改動程式碼**。

### ✅ 防止碰撞

演算法經過設計，極難被暴力破解。

---

## 📚 總結要點

| 項目 | 說明 |
|------|------|
| **預處理語句** | 防止 SQL 注入攻擊 |
| **password_hash()** | 加密並存儲密碼 |
| **password_verify()** | 驗證登入時的密碼 |
| **PDO** | 更安全的資料庫連接方式 |
| **加鹽 (Salt)** | 防止彩虹表攻擊 |
| **不可逆** | 雜湊無法被反解 |

