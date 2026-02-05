# first 目錄內容說明
## 安裝 Laragon
 
Laragon 是一個在 Windows 上非常強大且輕量級的開發環境。它不僅集成了伺服器（Apache/Nginx）、資料庫（MySQL/MariaDB）和 PHP，還能自動處理虛擬主機（Virtual Hosts），讓你用類似 myproject.test 的網址直接訪問本地專案，這對學習全端開發非常有幫助。

### 第一步：安裝與啟動 Laragon
下載並安裝：前往 Laragon 官網 下載 Full 版本（包含更多預裝工具如 Node.js, Git, Redis）。

啟動服務：打開 Laragon，點擊下方的 「Start All」。這會啟動 Apache 和 MySQL。

基礎配置：

Web 目錄：預設專案資料夾在 C:\laragon\www。

資料庫管理：點擊 「Database」 會開啟 HeidiSQL 或 phpMyAdmin（視版本而定）。預設使用者為 root，密碼為空字串。
我會使用 phpMyAdmin

### 第二步：建立你的第一個全端專案
我們來寫一個簡單的程式：從資料庫讀取資料並顯示在網頁上。這涵蓋了前端（HTML/CSS）與後端（PHP/SQL）的基本概念。

1. 建立專案資料夾
在 Laragon 介面點擊右鍵：Quick app -> Blank，輸入專案名稱（例如 my_first_app）。 這會在 C:\laragon\www\my_first_app 建立資料夾。

2. 建立資料庫與資料表
點擊 「Database」，連線後建立一個名為 test_db 的資料庫，並執行以下 SQL：
```SQL 
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    email VARCHAR(50)
);

INSERT INTO users (name, email) VALUES ('夥伴', 'partner@example.com');
```
### 第三步：編寫後端程式碼 (PHP)
在 C:\laragon\www\first 資料夾下建立一個 index.php 檔案，並貼入以下程式碼：
```php
<?php
// 後端邏輯：連接資料庫
$host = 'localhost';
$db   = 'test_db';
$user = 'root';
$pass = ''; // Laragon 預設無密碼

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 取得資料
    $stmt = $pdo->query("SELECT * FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("資料庫連線失敗: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>我的第一個全端網頁</title>
    <style>
        body { font-family: sans-serif; background: #f4f4f4; padding: 50px; }
        .card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        h1 { color: #333; }
    </style>
</head>
<body>
    <div class="card">
        <h1>使用者列表</h1>
        <ul>
            <?php foreach ($users as $user): ?>
                <li><?php echo $user['name']; ?> (<?php echo $user['email']; ?>)</li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
```
如何執行與導入
確認服務運作：確保 Laragon 的 Apache 與 MySQL 狀態為「Started」。

瀏覽網頁：
你可以點擊 Laragon 介面的 「Web」 進入 localhost。
http://localhost/first

* 或是直接在瀏覽器輸入 http://my_first_app.test（Laragon 會自動幫你設定好這個虛擬網址）。


------------
雖然 Laragon 預設使用 HeidiSQL（一個桌面端的資料庫管理工具），但對於全端開發學習者來說，使用網頁介面的 phpMyAdmin 的確更直觀，且與許多線上虛擬主機的環境一致。
在 Laragon 中切換或安裝 phpMyAdmin 非常簡單，以下是具體的導入步驟：

#### 方法一：使用 Laragon 的「快速增加」功能（推薦）
這是最簡單的方法，Laragon 會自動幫你下載並配置好。

開啟 Laragon 介面。

點擊滑鼠右鍵開啟選單，選擇：「Tools」 (工具) -> 「Quick add」 (快速增加) -> 「*phpMyAdmin」。

此時會彈出一個命令列視窗，自動下載並解壓縮 phpMyAdmin。

完成後，你只要點擊 Laragon 主介面的 「Database」 按鈕，它就會自動在瀏覽器中開啟 http://localhost/phpmyadmin。

注意：如果你的 PHP 版本較新（如 PHP 8.2+），建議選擇 phpmyadmin6.0snapshot 或手動更新以獲得更好的相容性。

#### 方法二：手動安裝（若快速增加失敗時使用）
如果你想指定特定版本的 phpMyAdmin，可以按照以下步驟手動導入：

下載：前往 phpMyAdmin 官方網站 下載最新的 .zip 檔。

解壓縮：將下載的資料夾解壓縮到 Laragon 的路徑下：C:\laragon\etc\apps。

重新命名：將解壓縮後的資料夾名稱（如 phpMyAdmin-5.2.1-all-languages）改為簡單的 phpMyAdmin。

登入：

在瀏覽器輸入 http://localhost/phpmyadmin。

使用者名稱：root

密碼：空字串（預設無密碼）。

解決「無法直接進入」的問題
如果點擊「Database」按鈕仍然跳出 HeidiSQL，這是因為 Laragon 的預設路徑設定。你可以手動修改：

進入 C:\laragon\etc\apps\phpMyAdmin。

將 config.sample.inc.php 複製並更名為 config.inc.php。

搜尋 
``` 
$cfg['Servers'][$i]['AllowNoPassword'] 
```
並確保其值為 true：
```
$cfg['Servers'][$i]['AllowNoPassword'] = true;
```
phpMyAdmin 與 HeidiSQL 的差異

| 項目 | phpMyAdmin | HeidiSQL |
| --- | --- | --- |
| 功能 | phpMyAdmin | HeidiSQL |
| 介面類型 | 網頁版 (Web-based) | 桌面軟體 (Desktop App) |
| 學習重點 | 適合練習網頁與資料庫互動 | 適合處理大量數據與複雜查詢 |
| 環境一致性 | 與大多數 Linux 伺服器環境相同 | 僅限 Windows 環境使用 |


Laragon 是一個高度「可攜式 (Portable)」且「孤立 (Isolated)」的軟體。

--------
f02.html

一個完整的 HTML 範例，將重要標籤整合進一個標準的網頁版面中，並加上了 CSS 樣式，方便看出這些區塊在畫面上的位置與用途。

標籤觀念複習
容器區塊 (&lt;div&gt;) vs. 段落部分 (&lt;span&gt;)：

&lt;div&gt; 是 區塊元素 (Block-level)：它會像積木一樣疊在一起，預設寬度是 100%。

&lt;span&gt; 是 行內元素 (Inline)：它會跟著文字走，只包裹它範圍內的文字，不會造成換行。

區塊 (&lt;section&gt;) vs. 文章 (&lt;article&gt;)：

&lt;section&gt; 通常是一本書的一個「章節」。

&lt;article&gt; 則是可以「獨立拿出來看」的內容，例如一篇部落格文章、一個新聞卡片。

側欄 (&lt;aside&gt;)：

裡面的內容通常與主內容相關，但不是最重要的（例如：相關閱讀、熱門標籤）。

--------
f03.html
示範 網頁中最重要的「互動與媒體」元素：&lt;table&gt; 用於展示數據，&lt;img&gt; 用於顯示圖片，而 &lt;a&gt; 則是網頁之間的橋樑（超連結）。

1. &lt;table&gt; (表格) 的結構：
&lt;table&gt;: 表格的本體。

&lt;tr&gt; (Table Row): 定義「一列」。

&lt;th&gt; (Table Header): 定義「標題欄位」，文字預設會加粗並置中。

&lt;td&gt; (Table Data): 定義「一般資料欄位」。

提示：開發後端時，我們常會用 PHP 的 foreach 迴圈來重複產生 &lt;tr&gt; 以顯示資料庫中的多筆資料。

2. &lt;img&gt; (圖片) 的屬性：
src: 圖片的來源路徑（可以是本地檔案或網路網址）。

alt: 必填的好習慣！當圖片無法讀取時顯示的文字，對盲人輔具（螢幕閱讀器）非常重要。

3. &lt;a&gt; (超連結) 的技巧：
href: 連結的目的地。

target="_blank": 這是一個很常用的屬性，可以讓連結在「新分頁」打開，而不會讓使用者離開你的網站。

------------------------
calculator.php

這段程式碼包含了三個關鍵概念：

1. HTML 表單屬性
   
   method="POST": 這告訴瀏覽器「隱密地」將資料傳送給伺服器，這是傳送表單資料最常用的方式。

   name="num1": 這是 PHP 識別資料的「標籤」。沒有 name，PHP 就拿不到資料。

2. PHP 接收機制 ($_POST)
    
    isset($_POST['calculate']): 這行是檢查使用者是否「按下了按鈕」。如果不檢查，網頁一打開（還沒輸入時）就會執行運算，導致報錯。

    $_POST['num1']: PHP 會根據 HTML 裡的 name 屬性，把資料存進這個超全域陣列中。

3. 資料處理流程

    瀏覽器 (Client)：使用者填寫數字並按下「計算」。

    伺服器 (Server)：PHP 接收到請求，從 $_POST 挖出數字，完成相加。

    瀏覽器 (Client)：PHP 將結果嵌入 HTML，使用者看到最終結果。