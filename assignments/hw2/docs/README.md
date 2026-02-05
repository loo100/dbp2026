# 作業 2：會員系統

## 任務目標

開發完整的會員管理系統，包含安全驗證與檔案處理。

## 功能需求

1. **註冊功能**：使用 `password_hash()` 儲存加密密碼
2. **登入功能**：使用 `password_verify()` 驗證，並建立 `Session`
3. **寄信驗證**：註冊後發送驗證信（可使用 PHPMailer 搭配 Gmail SMTP）
4. **頭像上傳**：允許使用者上傳圖片，並限制檔案大小與格式

## 技術重點

- **Session 管理**：`session_start()`, `$_SESSION`
- **檔案上傳**：`$_FILES`, `move_uploaded_file()`
- **安全性**：防止 SQL Injection (使用 Prepared Statements)
- **郵件發送**：PHPMailer 或 mail() 函數

## 評分標準

- 功能完整性 (40%)
- 安全性實現 (30%)
- 使用者體驗 (20%)
- 程式碼品質 (10%)
