-- 建立使用者表
CREATE TABLE IF NOT EXISTS noteusers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 建立筆記表
CREATE TABLE IF NOT EXISTS notes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    content TEXT NOT NULL,
    image_path VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES noteusers(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id)
);

-- 插入測試使用者
INSERT INTO users (username, password, email) VALUES 
('testuser', '$2y$10$8K1X...(需要用 password_hash() 生成的密碼)', 'test@example.com');
