# AJAX 與 PHP 完整教學

AJAX (Asynchronous JavaScript and XML) 是現代 Web 應用必須掌握的技術。它允許網頁在後台與伺服器進行通訊，無需重新整理頁面。

## 目錄

1. [AJAX 基本概念](#1-ajax-基本概念)
2. [運作流程](#2-運作流程)
3. [基礎範例](#3-基礎範例)
4. [進階範例](#4-進階範例)

---

## 1. AJAX 基本概念

### 什麼是 AJAX？

AJAX 是一組技術的組合：
- **A**synchronous（非同步）：不阻塞使用者操作
- **JavaScript**：客戶端語言
- **XML/JSON**：資料交換格式

AJAX（Asynchronous JavaScript and XML）：用 JavaScript 在背景向伺服器發送請求、取得資料，再更新頁面的一部分，不用整頁重整。

- 現代 AJAX 多用 JSON，不一定是 XML；本質是「前端非同步呼叫後端 API」。

### AJAX 的優勢

| 特性 | 說明 |
|------|------|
| **無需重整頁面** | 使用者體驗更流暢 |
| **減少頻寬** | 只傳輸必要資料 |
| **即時回饋** | 實時驗證、自動完成等 |
| **提升互動性** | 類似桌面應用的感受 |

### AJAX 與傳統表單的差異

**傳統表單：**
```
使用者輸入 → 提交表單 → 頁面全部重新整理 → 伺服器回傳
```

**AJAX：**
```
使用者輸入 → JavaScript 攔截 → 後台傳送請求 → 伺服器回傳資料 → 動態更新頁面（不重整）
```

---

## 2. 運作流程

### 完整的 AJAX 流程

1. 前端事件：click / input / change

2. JavaScript 送出 HTTP Request

    - 方法：GET / POST / PUT / DELETE（課程可先從 GET/POST）

    - 資料格式：QueryString、FormData、JSON Body

3. PHP 接收資料（$_GET, $_POST, 或讀 raw body）

4. PHP 回應資料（通常 JSON）

5. 前端解析 JSON，更新 DOM

### 實現 AJAX 的方式

1. **XMLHttpRequest**（傳統，已支援所有瀏覽器）
2. **Fetch API**（現代，推薦）
3. **jQuery AJAX**（需引入 jQuery）
4. **Axios**（第三方庫）

本教學主要使用 **Fetch API** 和 **XMLHttpRequest**。

---

## 3. 基礎範例

### 3.1 簡單的 GET 請求

**前端 HTML + JavaScript：**

```html
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>AJAX 基礎範例</title>
</head>
<body>
    <h1>問候應用</h1>
    <input type="text" id="username" placeholder="輸入你的名字">
    <button onclick="greet()">說你好</button>
    <div id="result"></div>

    <script>
        function greet() {
            const username = document.getElementById('username').value;
            
            // 使用 Fetch API
            fetch('greet.php?name=' + username)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('result').innerHTML = data;
                });
        }
    </script>
</body>
</html>
```

**後端 PHP (greet.php)：**

```php
<?php
header('Content-Type: text/html; charset=utf-8');

$name = isset($_GET['name']) ? htmlspecialchars($_GET['name']) : '訪客';

echo "你好，$name！歡迎使用 AJAX。";
?>
```

**運作流程：**
1. 使用者輸入名字，按下按鈕
2. JavaScript 攔截，取得輸入值
3. Fetch 向 `greet.php` 發起 GET 請求
4. PHP 接收名字，傳回問候訊息
5. JavaScript 接收回傳，更新頁面

---

### 3.2 POST 請求與 JSON

**前端 HTML + JavaScript：**

```html
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>AJAX POST 範例</title>
</head>
<body>
    <h1>使用者資訊查詢</h1>
    <input type="number" id="userid" placeholder="輸入使用者 ID">
    <button onclick="getUserInfo()">查詢</button>
    <div id="result"></div>

    <script>
        function getUserInfo() {
            const userId = document.getElementById('userid').value;

            fetch('a_user.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    id: userId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('result').innerHTML = `
                        <p>姓名：${data.name}</p>
                        <p>信箱：${data.email}</p>
                        <p>城市：${data.city}</p>
                    `;
                } else {
                    document.getElementById('result').innerHTML = '使用者不存在';
                }
            });
        }
    </script>
</body>
</html>
```

**後端 PHP (a_user.php)：**

```php
<?php
header('Content-Type: application/json; charset=utf-8');

// 取得 POST 資料
$input = json_decode(file_get_contents('php://input'), true);
$userId = intval($input['id'] ?? 0);

// 模擬資料庫
$users = [
    1 => ['name' => '李明', 'email' => 'liming@example.com', 'city' => '台北'],
    2 => ['name' => '王芳', 'email' => 'wangfang@example.com', 'city' => '台中'],
    3 => ['name' => '張三', 'email' => 'zhangsan@example.com', 'city' => '高雄']
];

$result = [
    'success' => false,
    'name' => '',
    'email' => '',
    'city' => ''
];

if (isset($users[$userId])) {
    $result['success'] = true;
    $result['name'] = $users[$userId]['name'];
    $result['email'] = $users[$userId]['email'];
    $result['city'] = $users[$userId]['city'];
}

echo json_encode($result);
?>
```

**重點：**
- 使用 `method: 'POST'` 指定請求方式
- 用 `JSON.stringify()` 序列化資料
- PHP 用 `json_decode(file_get_contents('php://input'))` 接收 JSON
- 回傳 `JSON` 格式，方便 JavaScript 解析

---

## 4. 進階範例

### 4.1 表單即時驗證

**前端 HTML + JavaScript：**

```html
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>即時驗證範例</title>
    <style>
        .form-group { margin-bottom: 15px; }
        .input-field { padding: 8px; }
        .valid { color: green; }
        .invalid { color: red; }
    </style>
</head>
<body>
    <h1>使用者帳號註冊</h1>
    <div class="form-group">
        <label>帳號：</label>
        <input type="text" id="username" class="input-field" placeholder="長度 3-20">
        <span id="username-check"></span>
    </div>

    <div class="form-group">
        <label>信箱：</label>
        <input type="email" id="email" class="input-field" placeholder="輸入有效信箱">
        <span id="email-check"></span>
    </div>

    <button onclick="register()">註冊</button>

    <script>
        // 即時驗證帳號
        document.getElementById('username').addEventListener('blur', function () {
            const username = this.value;

            fetch('validate.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ field: 'username', value: username })
            })
            .then(response => response.json())
            .then(data => {
                const checkSpan = document.getElementById('username-check');
                if (data.valid) {
                    checkSpan.innerHTML = '✓ 帳號可用';
                    checkSpan.className = 'valid';
                } else {
                    checkSpan.innerHTML = '✗ ' + data.message;
                    checkSpan.className = 'invalid';
                }
            });
        });

        // 即時驗證信箱
        document.getElementById('email').addEventListener('blur', function () {
            const email = this.value;

            fetch('validate.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ field: 'email', value: email })
            })
            .then(response => response.json())
            .then(data => {
                const checkSpan = document.getElementById('email-check');
                if (data.valid) {
                    checkSpan.innerHTML = '✓ 信箱格式正確';
                    checkSpan.className = 'valid';
                } else {
                    checkSpan.innerHTML = '✗ ' + data.message;
                    checkSpan.className = 'invalid';
                }
            });
        });

        function register() {
            alert('表單驗證完成，可進行註冊！');
        }
    </script>
</body>
</html>
```

**後端 PHP (validate.php)：**

```php
<?php
header('Content-Type: application/json; charset=utf-8');

$input = json_decode(file_get_contents('php://input'), true);
$field = $input['field'] ?? '';
$value = $input['value'] ?? '';

$result = ['valid' => false, 'message' => ''];

// 驗證帳號
if ($field === 'username') {
    if (strlen($value) < 3) {
        $result['message'] = '帳號長度至少 3 個字';
    } elseif (strlen($value) > 20) {
        $result['message'] = '帳號長度不超過 20 個字';
    } else {
        // 模擬檢查帳號是否已被使用
        $taken_users = ['admin', 'user123', 'test'];
        if (in_array(strtolower($value), $taken_users)) {
            $result['message'] = '帳號已被使用';
        } else {
            $result['valid'] = true;
        }
    }
}

// 驗證信箱
if ($field === 'email') {
    if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
        $result['message'] = '信箱格式不正確';
    } else {
        // 模擬檢查信箱是否已被使用
        $taken_emails = ['test@example.com', 'admin@example.com'];
        if (in_array(strtolower($value), $taken_emails)) {
            $result['message'] = '此信箱已註冊';
        } else {
            $result['valid'] = true;
        }
    }
}

echo json_encode($result);
?>
```

**運作方式：**
- 使用者輸入帳號或信箱後，無需提交表單即可驗證
- JavaScript 監聽 `blur` 事件（失焦時觸發）
- 向後端發送驗證請求
- 根據回傳結果即時顯示驗證狀態

---

### 4.2 搜尋功能（帶防抖）

**前端 HTML + JavaScript：**

```html
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>搜尋功能</title>
    <style>
        .search-box { position: relative; width: 300px; }
        .search-input { width: 100%; padding: 8px; }
        .dropdown { position: absolute; top: 100%; width: 100%; border: 1px solid #ddd; 
                   background: #fff; display: none; }
        .dropdown-item { padding: 8px; cursor: pointer; }
        .dropdown-item:hover { background: #f0f0f0; }
    </style>
</head>
<body>
    <h1>產品搜尋</h1>
    <div class="search-box">
        <input type="text" id="search" class="search-input" placeholder="搜尋產品...">
        <div id="dropdown" class="dropdown"></div>
    </div>

    <script>
        let searchTimeout;

        document.getElementById('search').addEventListener('input', function () {
            const query = this.value;

            // 防抖：200ms 後才發送請求
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                if (query.length === 0) {
                    document.getElementById('dropdown').style.display = 'none';
                    return;
                }

                fetch('search_products.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ query: query })
                })
                .then(response => response.json())
                .then(data => {
                    const dropdown = document.getElementById('dropdown');
                    if (data.results.length === 0) {
                        dropdown.innerHTML = '<div class="dropdown-item">無搜尋結果</div>';
                    } else {
                        dropdown.innerHTML = data.results.map(product =>
                            `<div class="dropdown-item">${product.name} - NT$${product.price}</div>`
                        ).join('');
                    }
                    dropdown.style.display = 'block';
                });
            }, 200);
        });
    </script>
</body>
</html>
```

**後端 PHP (search_products.php)：**

```php
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
```

**重點：**
- **防抖（Debounce）**：避免每次按鍵都發送請求
- 搜尋結果以下拉清單顯示
- 無需提交就能獲得即時搜尋結果

---

### 4.3 動態載入更多資料（無限滾動）

**前端 HTML + JavaScript：**

```html
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>無限滾動</title>
    <style>
        body { font-family: Arial; }
        #content { max-width: 600px; margin: 0 auto; }
        .post { border: 1px solid #ddd; padding: 12px; margin-bottom: 12px; }
        .post h3 { margin: 0; }
        .post p { margin: 8px 0 0 0; color: #666; }
        #loading { text-align: center; color: #999; }
    </style>
</head>
<body>
    <h1>文章列表（無限滾動）</h1>
    <div id="content"></div>
    <div id="loading">載入中...</div>

    <script>
        let page = 1;
        let isLoading = false;

        function loadMore() {
            if (isLoading) return;
            isLoading = true;

            fetch('load_posts.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ page: page })
            })
            .then(response => response.json())
            .then(data => {
                const content = document.getElementById('content');
                data.posts.forEach(post => {
                    content.innerHTML += `
                        <div class="post">
                            <h3>${post.title}</h3>
                            <p>${post.content}</p>
                        </div>
                    `;
                });
                page++;
                isLoading = false;
                document.getElementById('loading').style.display = 'none';
            });
        }

        // 初始載入
        loadMore();

        // 滾動到底部時載入更多
        window.addEventListener('scroll', function () {
            if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 200) {
                loadMore();
            }
        });
    </script>
</body>
</html>
```

**後端 PHP (load_posts.php)：**

```php
<?php
header('Content-Type: application/json; charset=utf-8');

$input = json_decode(file_get_contents('php://input'), true);
$page = intval($input['page'] ?? 1);

// 模擬文章資料庫
$allPosts = [];
for ($i = 1; $i <= 50; $i++) {
    $allPosts[] = [
        'title' => "文章 $i",
        'content' => "這是文章 $i 的內容摘要..."
    ];
}

// 分頁：每頁 5 篇
$perPage = 5;
$start = ($page - 1) * $perPage;
$posts = array_slice($allPosts, $start, $perPage);

echo json_encode(['posts' => $posts]);
?>
```

**運作方式：**
- 頁面載入時自動取得第 1 頁資料
- 使用者滾動到底部時自動載入下一頁
- 每次載入 5 篇文章，無需刷新頁面

---

## 5. 最佳實踐

### 錯誤處理

```javascript
fetch('api.php')
    .then(response => {
        if (!response.ok) throw new Error('網路錯誤');
        return response.json();
    })
    .then(data => console.log(data))
    .catch(error => console.error('發生錯誤：', error));
```

### 超時控制

```javascript
const timeoutPromise = new Promise((_, reject) =>
    setTimeout(() => reject(new Error('請求逾時')), 5000)
);

Promise.race([fetch('api.php'), timeoutPromise])
    .then(response => response.json())
    .catch(error => console.error(error));
```

### 安全性考量

- **XSS 防護**：使用 `htmlspecialchars()` 或 `strip_tags()`
- **CSRF 防護**：在表單中加入 token
- **輸入驗證**：始終驗證使用者輸入
- **HTTPS**：在生產環境使用加密連線

---

## 小結

| 階段 | 技術 | 說明 |
|------|------|------|
| **基礎** | Fetch / XMLHttpRequest | 簡單的資料傳輸 |
| **中階** | JSON 解析、事件處理 | 涉及表單驗證、搜尋功能 |
| **進階** | 防抖、節流、分頁 | 高效能的互動體驗 |

AJAX 是現代 Web 應用必不可少的技能，掌握它能大幅提升使用者體驗！
