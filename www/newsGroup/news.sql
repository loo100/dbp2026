
-- Main news table
CREATE TABLE news (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    content TEXT NOT NULL,
    author VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Replies table
CREATE TABLE replies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    news_id INT NOT NULL,
    content TEXT NOT NULL,
    author VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (news_id) REFERENCES news(id) ON DELETE CASCADE,
    INDEX idx_news_id (news_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert sample data
INSERT INTO news (title, content, author) VALUES
('歡迎來到討論區', '這是第一則討論，歡迎大家發表意見！', '管理員'),
('PHP 學習心得', '最近開始學習 PHP ，發現它真的很好用！', '小明'),
('RESTful API 討論', '大家都怎麼設計 RESTful API ？有什麼建議嗎？', '開發者');

INSERT INTO replies (news_id, content, author) VALUES
(1, '感謝管理員建立這個討論區！', '小華'),
(1, '很高興能加入這個社群', '小李'),
(2, 'PHP 確實很強大，推薦看看 Laravel 框架', '資深工程師');
