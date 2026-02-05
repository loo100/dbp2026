CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    email VARCHAR(50)
);

INSERT INTO users (name, email) VALUES ('夥伴', 'partner@example.com');