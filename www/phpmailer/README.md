# PHP Google 寄信

針對你的需求，若要棄用不安全的「低安全性應用程式存取（App Passwords）」，目前的標準做法是使用 OAuth 2.0 協議。這是一種透過「令牌（Token）」而非「密碼」來授權的方式，安全性更高。

在 PHP 環境中，最推薦的實作方式是使用 PHPMailer 配合 Google OAuth2 套件。

🚀 開發步驟概覽
要達成這個目標，我們需要完成以下三個主要階段：

Google Cloud 專案設定：取得憑證（Client ID & Secret）。

取得實體授權（Refresh Token）：這是一次性的動作，用來換取可以長期使用的授權令牌。

編寫 PHP 寄信程式碼：整合憑證發信。

## 第一階段：Google Cloud Console 設定
前往 Google Cloud Console。

建立專案：點擊左上角，建立一個新專案。

啟用 API：搜尋並啟用 "Gmail API"。

OAuth 同意畫面：

使用者類型選擇「外部（External）」。

填寫必要的應用程式名稱與電子郵件。

範圍（Scopes）：新增 https://mail.google.com/。

測試使用者：務必新增你用來寄信的那個 Gmail 帳號。

建立憑證：

點擊「建立憑證」 > 「OAuth 用戶端 ID」。

應用程式類型選擇「Web 應用程式」。

已授權的重新導向 URI：填入 http://localhost/phpmailer/get_oauth_token.php（這能幫我們快速取得 Token）。

記下你的 Client ID 與 Client Secret。

## 第二階段：安裝必要套件
請確保你的環境已安裝 Composer，然後在專案目錄執行：

```Bash
composer require phpmailer/phpmailer
composer require league/oauth2-google
```

第三階段：編寫寄信程式碼
1. 取得 Refresh Token
首先，你需要執行 get_oauth_token.php , 填入你的 ID 和 Secret，授權後取得 Refresh Token。

2. 寄信主程式碼
這段程式碼會自動處理 Token 的過期與更新：

```PHP
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\OAuth;
use League\OAuth2\Client\Provider\Google;

require 'vendor/autoload.php';

// --- 設定參數 ---
$emailAddress = 'your-email@gmail.com';
$clientId = '你的_CLIENT_ID';
$clientSecret = '你的_CLIENT_SECRET';
$refreshToken = '你的_REFRESH_TOKEN';

$mail = new PHPMailer(true);

try {
    // 伺服器設定
    $mail->isSMTP();
    $mail->SMTPDebug = SMTP::DEBUG_OFF; // 除錯模式：DEBUG_SERVER
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 465;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->SMTPAuth = true;
    $mail->AuthType = 'XOAUTH2';

    // OAuth2 認證
    $provider = new Google([
        'clientId'     => $clientId,
        'clientSecret' => $clientSecret,
    ]);

    $mail->setOAuth(new OAuth([
        'provider'     => $provider,
        'clientId'     => $clientId,
        'clientSecret' => $clientSecret,
        'refreshToken' => $refreshToken,
        'userName'     => $emailAddress,
    ]));

    // 收件人與內容
    $mail->setFrom($emailAddress, '寄件者名稱');
    $mail->addAddress('recipient@example.com', '收件者名稱');
    $mail->isHTML(true);
    $mail->Subject = '這是使用 OAuth2 寄送的測試信件';
    $mail->Body    = '恭喜！你已經成功透過 <b>Gmail OAuth2</b> 寄出信件。';

    $mail->send();
    echo '信件已成功寄出！';
} catch (Exception $e) {
    echo "寄送失敗。錯誤訊息: {$mail->ErrorInfo}";
}
```

📖 重點說明
為什麼要用 refreshToken？
OAuth 的 Access Token 通常幾小時就過期了。透過 refreshToken，PHPMailer 可以在寄信前自動向 Google 請求新的 Token，無需人工干預。

安全性：
你的 clientSecret 和 refreshToken 應存放在環境變數（.env）中，切勿直接上傳至公開的 GitHub 儲存庫。

應用程式狀態：
若你的專案在 Google Console 處於「測試」狀態，Token 可能在 7 天後過期。若要長期運行，建議將專案發布為「生產」狀態（即使不提交驗證也可，只要使用者不超過上限）。

請問你在設定 Google Cloud Console 或是取得 Refresh Token 的過程中有遇到任何困難嗎？我也能幫你寫一個簡單的腳本來產生 Refresh Token。

## ssl 錯誤處理
你的 PHP 環境（Laragon）想要透過 HTTPS 連線到 Google 伺服器來換取 Token，有時找不到用來驗證安全性連線的「憑證檔案（cacert.pem）」，或者該路徑指向了一個不存在的位置。就會出現有關 ssl 錯誤。

🛠️ 修正方法：重新設定 php.ini
你不需要修改程式碼，只需要修正 PHP 的設定。請按照以下步驟操作：

步驟 1：下載最新的憑證檔案

前往 curl 官方網站下載：cacert.pem。 ( laragon 已經自動提供，不須再下載，非 laragon 請自行找到對應的地方)

將下載好的 cacert.pem 檔案放在你的 Laragon 目錄下，例如：D:\laragon\etc\ssl\cacert.pem。

步驟 2：修改 php.ini 設定
在 Laragon 介面上點擊 右鍵 > PHP > php.ini（這會用記事本打開設定檔）。

使用 Ctrl + F 搜尋 curl.cainfo。

找到以下兩行（如果前面有 ; 符號，請務必刪除它來啟用）：

```Ini, TOML
curl.cainfo = "D:\laragon\etc\ssl\cacert.pem"
openssl.cafile = "D:\laragon\etc\ssl\cacert.pem"
```
(請確保路徑與你剛剛存放檔案的位置完全一致)

步驟 3：重啟 Laragon 服務
在 Laragon 介面點擊 "Stop"，然後點擊 "Start All"。

重新執行你的 get_oauth_token.php 腳本。

## 範例

### 1
send_email.php
### 2
send.php + pmail.inc.php
### 3
send01.html + send01.php(pmail.inc.php)

