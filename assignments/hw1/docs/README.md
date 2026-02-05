# 作業 1：留言板/討論區

## 任務目標

建立一個簡單的留言板系統，練習基本的資料庫存取 (CRUD)。

## 功能需求

1. **顯示留言**：從資料庫讀取所有留言並顯示
2. **新增留言**：提供表單讓使用者輸入姓名與內容
3. **資料驗證**：確保欄位不為空
4. **安全防護**：使用 `htmlspecialchars()` 防止 XSS 攻擊

## 資料庫結構

```sql
CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

## 技術要點

- 使用 PDO 進行資料庫操作
- Prepared Statements 防止 SQL Injection
- htmlspecialchars() 防止 XSS 攻擊
- 時間戳記自動記錄

## 評分標準

- 功能完整性 (40%)
- 程式碼結構 (30%)
- 安全性 (20%)
- 使用者介面 (10%)
