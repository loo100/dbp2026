-- 作業 1：留言板資料庫初始化

CREATE DATABASE IF NOT EXISTS guestbook;
USE guestbook;

CREATE TABLE IF NOT EXISTS messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 插入範例資料
INSERT INTO messages (name, content) VALUES
('Alice', '歡迎來到留言板！'),
('Bob', '這是一個很好的練習項目。'),
('Charlie', '期待看到更多功能！');
