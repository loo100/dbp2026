# 📧 郵件發送系統使用說明

## 📋 目錄
1. [系統簡介](#系統簡介)
2. [系統需求](#系統需求)
3. [Google 應用程式密碼申請教學](#google-應用程式密碼申請教學)
4. [系統設定](#系統設定)
5. [使用流程](#使用流程)
6. [常見問題](#常見問題)

---

## 系統簡介

本郵件發送系統使用 PHPMailer 函式庫，透過 SMTP 協定發送電子郵件。系統包含三個核心文件：

- **tomail.html** - 郵件填寫表單頁面
- **tosend.php** - 郵件發送處理程式
- **sended.php** - 發送成功確認頁面

---

## 系統需求

### 軟體需求
- PHP 7.4 或以上版本
- Composer（PHP 套件管理工具）
- PHPMailer 函式庫
- 支援 SMTP 的郵件伺服器（例如：Gmail）

### 安裝 PHPMailer

在專案根目錄執行以下指令：

```bash
composer require phpmailer/phpmailer
```

或在 `composer.json` 中加入：

```json
{
    "require": {
        "phpmailer/phpmailer": "^7.0"
    }
}
```

然後執行：

```bash
composer install
```

---

## Google 應用程式密碼申請教學

### ⚠️ 重要事項
Gmail 自 2022 年 5 月 30 日起，停止支援「低安全性應用程式存取」，必須使用「應用程式密碼」來進行 SMTP 驗證。

### 📝 前置條件
1. 擁有 Google 帳戶
2. 已啟用 Google 兩步驟驗證（2FA）

---

### 步驟 1：啟用兩步驟驗證

如果尚未啟用，請先完成以下步驟：

1. 前往 [Google 帳戶安全性頁面](https://myaccount.google.com/security)
2. 在「登入 Google」區段中，點選「兩步驟驗證」
3. 點選「開始使用」
4. 依照畫面指示完成手機驗證設定
5. 確認兩步驟驗證已啟用（狀態顯示為「已開啟」）

---

### 步驟 2：產生應用程式密碼

1. **進入 Google 帳戶管理頁面**
   - 訪問：https://myaccount.google.com/
   - 或點選 Gmail 右上角頭像 → 「管理你的 Google 帳戶」

2. **進入安全性設定**
   - 點選左側選單的「安全性」
   - 或直接訪問：https://myaccount.google.com/security

3. **找到應用程式密碼選項**
   - 在「登入 Google」區段中
   - 點選「應用程式密碼」（App passwords）
   - 可能需要再次輸入 Google 帳戶密碼驗證身份

4. **產生新的應用程式密碼**
   - 在「選取應用程式」下拉選單中選擇「郵件」
   - 在「選取裝置」下拉選單中選擇「其他（自訂名稱）」
   - 輸入裝置名稱，例如：「PHP 郵件系統」或「網站郵件功能」
   - 點選「產生」按鈕

5. **儲存應用程式密碼**
   - Google 會顯示一組 16 位數的應用程式密碼
   - 格式類似：`abcd efgh ijkl mnop`（會有空格）
   - **重要：立即複製此密碼，離開頁面後將無法再次查看**
   - 建議將密碼儲存在安全的地方

---

### 📱 視覺化步驟流程

```
Google 帳戶 → 安全性 → 兩步驟驗證（啟用）
                    ↓
            應用程式密碼 → 選擇「郵件」
                    ↓
            選擇「其他」→ 輸入名稱
                    ↓
            點選「產生」→ 複製 16 位密碼
                    ↓
            套用到 PHP 程式碼
```

---

### 🔑 應用程式密碼注意事項

1. **密碼格式**
   - Google 顯示的密碼會有空格（例如：`abcd efgh ijkl mnop`）
   - 程式碼中**可以保留空格或移除**，兩者皆可使用
   
2. **安全性**
   - 應用程式密碼等同於帳戶密碼，請妥善保管
   - 不要將密碼上傳到公開的程式碼倉庫（GitHub、GitLab 等）
   - 建議使用環境變數或設定檔來儲存密碼

3. **管理與撤銷**
   - 可以在同一頁面查看所有已產生的應用程式密碼
   - 如果密碼洩漏，可立即撤銷該密碼
   - 撤銷後需要重新產生新密碼

4. **多個應用程式**
   - 可以為不同用途產生多組應用程式密碼
   - 例如：網站 A、網站 B、測試環境各用不同密碼
   - 方便管理和追蹤使用情況

---

## 系統設定

### 修改 SMTP 設定

編輯 `tosend.php` 文件，找到以下區段（約第 41-46 行）：

```php
// SMTP 伺服器設定 (以 Gmail 為例)
$mail->isSMTP();
$mail->Host       = 'smtp.gmail.com';
$mail->SMTPAuth   = true;
$mail->Username   = 'your-email@gmail.com';        // 👈 改為您的 Gmail 地址
$mail->Password   = 'your-app-password';           // 👈 改為您的應用程式密碼（16位）
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port       = 587;
```

### 設定範例

```php
$mail->Username   = 'example@gmail.com';
$mail->Password   = 'abcdefghijklmnop';  // 16位應用程式密碼（可含或不含空格）
```

### 使用環境變數（暫不建議設定，實務應用時再設定）

為了安全性，建議將敏感資訊存放在環境變數中：

#### 方法 1：使用 .env 文件

1. 安裝 vlucas/phpdotenv：
```bash
composer require vlucas/phpdotenv
```

2. 建立 `.env` 文件：
```
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
```

3. 在 PHP 中讀取：
```php
require 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$mail->Username = $_ENV['MAIL_USERNAME'];
$mail->Password = $_ENV['MAIL_PASSWORD'];
```

4. **重要：將 `.env` 加入 `.gitignore`**
```
.env
```

#### 方法 2：使用獨立設定檔

建立 `mail_config.php`（不上傳到版本控制）：

```php
<?php
return [
    'smtp_host' => 'smtp.gmail.com',
    'smtp_username' => 'your-email@gmail.com',
    'smtp_password' => 'your-app-password',
    'smtp_port' => 587,
];
```

在 `tosend.php` 中引用：

```php
$config = require 'mail_config.php';
$mail->Username = $config['smtp_username'];
$mail->Password = $config['smtp_password'];
```

---

## 使用流程

### 完整發信流程圖

```
使用者訪問
tomail.html
    ↓
填寫表單資料：
• 寄件人姓名
• 寄件人信箱
• 收件人姓名
• 收件人信箱
• 郵件主旨
• 郵件內容
• 附件檔案（選填）
    ↓
點擊「發送郵件」
    ↓
POST 提交到
tosend.php
    ↓
伺服器端處理：
1. 驗證表單資料
2. 驗證 Email 格式
3. 處理附件上傳
4. 建立 PHPMailer 物件
5. 設定 SMTP 參數
6. 組合郵件內容
7. 呼叫 SMTP 服務
    ↓
    發送成功？
    ↓          ↓
   是          否
    ↓          ↓
存入 Session  顯示錯誤
    ↓          返回重試
重導向至
sended.php
    ↓
顯示發送成功
確認頁面
```

---

### 詳細步驟說明

#### 第 1 步：開啟郵件表單

在瀏覽器中訪問：
```
http://localhost/tomail.html
```
或
```
http://your-domain.com/tomail.html
```

#### 第 2 步：填寫郵件資訊

| 欄位名稱 | 必填 | 說明 | 範例 |
|---------|------|------|------|
| 寄件人姓名 | ✅ | 您的名字 | 張三 |
| 寄件人信箱 | ✅ | 回覆用的信箱 | sender@example.com |
| 收件人姓名 | ✅ | 對方的名字 | 李四 |
| 收件人信箱 | ✅ | 接收郵件的信箱 | recipient@example.com |
| 郵件主旨 | ✅ | 郵件標題 | 關於專案合作事宜 |
| 郵件內容 | ✅ | 詳細訊息 | 您好，我想與您討論... |
| 附件檔案 | ❌ | 選擇性上傳 | document.pdf (≤10MB) |

#### 第 3 步：上傳附件（選填）

- 點擊「附件檔案」欄位
- 選擇要上傳的文件
- **檔案限制**：
  - 單一檔案大小上限：10 MB
  - 支援常見格式：PDF、Word、Excel、圖片等

#### 第 4 步：發送郵件

- 確認所有資訊正確
- 點擊「✉️ 發送郵件」按鈕
- 等待頁面跳轉（通常需要 2-5 秒）

#### 第 5 步：確認發送結果

**成功情況**：
- 自動跳轉至 `sended.php`
- 顯示綠色勾勾 ✅ 和確認訊息
- 列出完整的郵件資訊
- 可選擇「再發送一封」或「返回首頁」

**失敗情況**：
- 顯示錯誤訊息
- 說明失敗原因
- 提供「返回重試」連結

---

### 郵件內容格式

系統會自動將郵件內容轉換為美觀的 HTML 格式：

- **標題區**：紫色漸層背景，顯示「您收到一封新郵件」
- **內文區**：淺灰背景，顯示使用者輸入的內容
- **寄件人資訊**：藍色邊框區塊，顯示寄件人姓名和回覆信箱
- **頁尾**：小字顯示「此郵件透過郵件發送系統傳送」

---

## 常見問題

### ❓ 無法發送郵件

**可能原因與解決方法**：

1. **SMTP 設定錯誤**
   - 檢查 Gmail 地址是否正確
   - 確認應用程式密碼是否正確複製（16位）
   - 確認已啟用 Google 兩步驟驗證

2. **防火牆阻擋**
   - 確認伺服器可以訪問 smtp.gmail.com
   - 檢查 Port 587 是否開放
   - 測試指令：`telnet smtp.gmail.com 587`

3. **PHP 擴充模組未安裝**
   - 確認已安裝 `php-openssl` 擴充
   - 確認已啟用 `php-mbstring` 擴充
   - 檢查 `php.ini` 中的 `extension=openssl`

4. **Google 帳戶安全性設定**
   - 確認應用程式密碼仍有效（未被撤銷）
   - 檢查 Google 是否發送安全警告郵件
   - 前往 https://myaccount.google.com/security 查看可疑活動

---

### ❓ 收件人沒有收到郵件

**檢查項目**：

1. **檢查垃圾郵件資料夾**
   - 首次發送可能被標記為垃圾郵件
   - 將寄件地址加入通訊錄可改善送達率

2. **收件人信箱是否正確**
   - 確認無拼字錯誤
   - 確認信箱網域仍然有效

3. **查看發送記錄**
   - 檢查 Gmail 的「已傳送郵件」資料夾
   - 確認郵件確實已送出

4. **SPF、DKIM 設定**
   - 如使用自訂網域，需設定 SPF 記錄
   - 考慮使用 Gmail 的 DMARC 設定

---

### ❓ 附件無法上傳

**可能原因**：

1. **檔案過大**
   - 確認檔案小於 10 MB
   - 可修改 `tosend.php` 中的大小限制（第 60 行）

2. **PHP 上傳限制**
   - 檢查 `php.ini` 設定：
     - `upload_max_filesize = 10M`
     - `post_max_size = 12M`
     - `max_file_uploads = 20`
   - 修改後需重啟 Web 伺服器

3. **目錄權限問題**
   - 確認臨時上傳目錄 (`upload_tmp_dir`) 可寫入
   - Linux/Mac: `chmod 755 /tmp`

4. **檔案類型限制**
   - 可在 `tosend.php` 中加入檔案類型檢查
   - 禁止上傳可執行檔（.exe, .bat, .sh）

---

### ❓ 錯誤訊息解讀

| 錯誤訊息 | 原因 | 解決方法 |
|---------|------|---------|
| `SMTP Error: Could not authenticate` | 帳號密碼錯誤 | 檢查應用程式密碼 |
| `SMTP connect() failed` | 無法連接伺服器 | 檢查網路、防火牆、Port |
| `Could not instantiate mail function` | PHP mail 函數失敗 | 使用 SMTP 取代 PHP mail() |
| `Message body empty` | 郵件內容為空 | 檢查表單資料傳遞 |
| `Invalid address` | 信箱格式錯誤 | 使用正確的 email 格式 |
| `File upload error` | 檔案上傳失敗 | 檢查檔案大小、權限 |



---

### ❓ 安全性建議

1. **防止濫用**
   - 加入 CAPTCHA 驗證（reCAPTCHA）
   - 限制發送頻率（Rate Limiting）
   - 記錄 IP 地址

2. **防止垃圾郵件**
   - 驗證表單 Token（CSRF Protection）
   - 檢查信箱黑名單
   - 限制每日發送數量

3. **資料驗證**
   - 伺服器端驗證所有輸入
   - 過濾 HTML 標籤（防 XSS）
   - 驗證附件檔案類型

4. **敏感資訊保護**
   - 不要在程式碼中寫死密碼
   - 使用環境變數或加密設定檔
   - 定期更換應用程式密碼

---

## 📚 參考資源

- [PHPMailer 官方文件](https://github.com/PHPMailer/PHPMailer)
- [Google 應用程式密碼說明](https://support.google.com/accounts/answer/185833)
- [SMTP 協定說明](https://zh.wikipedia.org/wiki/簡單郵件傳輸協定)
- [Gmail SMTP 設定指南](https://support.google.com/mail/answer/7126229)

---

## 📞 技術支援

如遇到其他問題，請提供以下資訊：

- PHP 版本（執行 `php -v`）
- PHPMailer 版本
- 錯誤訊息完整內容
- 已嘗試的解決步驟


