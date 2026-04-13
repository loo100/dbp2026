-- 建立投票系統資料表

-- 候選項目表
CREATE TABLE candidates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 投票紀錄表
CREATE TABLE votes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    candidate_id INT NOT NULL,
    voter_name VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (candidate_id) REFERENCES candidates(id) ON DELETE CASCADE,
    UNIQUE KEY unique_voter (voter_name)
);

-- 建立索引以加快查詢速度
CREATE INDEX idx_voter_name ON votes(voter_name);
CREATE INDEX idx_candidate_id ON votes(candidate_id);
