<?php
header('Content-Type: text/html; charset=utf-8');

$host = 'localhost';
$db = 'test_db';
$user = 'root';
$password = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;charset=$charset";

function escape($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

try {
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    echo '<h1>資料庫連線失敗</h1>';
    echo '<p>請先確認 MySQL 伺服器是否啟動，並檢查 `db_config.php` 的連線設定。</p>';
    echo '<pre>' . escape($e->getMessage()) . '</pre>';
    exit;
}

try {
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $pdo->exec("USE `$db`");
    $pdo->exec(<<<'SQL'
CREATE TABLE IF NOT EXISTS guestbook (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,
    name VARCHAR(100) NOT NULL DEFAULT '',
    message TEXT NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
SQL
    );

    $pdo->exec(<<<'SQL'
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    nickname VARCHAR(50) NOT NULL,
    favorite_color VARCHAR(7) NOT NULL DEFAULT '#cccccc',
    avatar VARCHAR(50) NOT NULL DEFAULT '👤',
    is_admin TINYINT(1) NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
SQL
    );

    $checkColumn = $pdo->prepare('SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = :schema AND TABLE_NAME = :table AND COLUMN_NAME = :column');

    $checkColumn->execute([':schema' => $db, ':table' => 'guestbook', ':column' => 'name']);
    if (!(bool) $checkColumn->fetchColumn()) {
        $pdo->exec("ALTER TABLE guestbook ADD COLUMN name VARCHAR(100) NOT NULL DEFAULT ''");
    }

    $checkColumn->execute([':schema' => $db, ':table' => 'guestbook', ':column' => 'user_id']);
    if (!(bool) $checkColumn->fetchColumn()) {
        $pdo->exec('ALTER TABLE guestbook ADD COLUMN user_id INT NULL');
    }

    $checkColumn->execute([':schema' => $db, ':table' => 'users', ':column' => 'nickname']);
    if (!(bool) $checkColumn->fetchColumn()) {
        $pdo->exec("ALTER TABLE users ADD COLUMN nickname VARCHAR(50) NOT NULL DEFAULT ''");
    }

    $checkColumn->execute([':schema' => $db, ':table' => 'users', ':column' => 'email']);
    if (!(bool) $checkColumn->fetchColumn()) {
        $pdo->exec("ALTER TABLE users ADD COLUMN email VARCHAR(100) NOT NULL DEFAULT ''");
        $pdo->exec("ALTER TABLE users ADD UNIQUE (email)");
    }

    $checkColumn->execute([':schema' => $db, ':table' => 'users', ':column' => 'favorite_color']);
    if (!(bool) $checkColumn->fetchColumn()) {
        $pdo->exec("ALTER TABLE users ADD COLUMN favorite_color VARCHAR(7) NOT NULL DEFAULT '#cccccc'");
    }

    $checkColumn->execute([':schema' => $db, ':table' => 'users', ':column' => 'avatar']);
    if (!(bool) $checkColumn->fetchColumn()) {
        $pdo->exec("ALTER TABLE users ADD COLUMN avatar VARCHAR(50) NOT NULL DEFAULT '👤'");
    }

    $checkColumn->execute([':schema' => $db, ':table' => 'users', ':column' => 'is_admin']);
    if (!(bool) $checkColumn->fetchColumn()) {
        $pdo->exec('ALTER TABLE users ADD COLUMN is_admin TINYINT(1) NOT NULL DEFAULT 0');
    }

    $checkAdmin = (int) $pdo->query('SELECT COUNT(*) FROM users WHERE is_admin = 1')->fetchColumn();
    if ($checkAdmin === 0) {
        $password = password_hash('admin123', PASSWORD_DEFAULT);
        $pdo->prepare('INSERT IGNORE INTO users (username, password, email, nickname, favorite_color, avatar, is_admin) VALUES (?, ?, ?, ?, ?, ?, 1)')
            ->execute(['admin', $password, 'admin@example.com', '管理員', '#ff7f50', '🛡️']);
    }

    $columnStmt = $pdo->prepare('SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = :schema AND TABLE_NAME = :table AND COLUMN_NAME = :column');
    $columnStmt->execute([
        ':schema' => $db,
        ':table' => 'guestbook',
        ':column' => 'status',
    ]);
    $hasStatus = (bool) $columnStmt->fetchColumn();

    if (!$hasStatus) {
        $pdo->exec("ALTER TABLE guestbook ADD COLUMN status VARCHAR(20) NOT NULL DEFAULT 'pending'");
    }

    echo '<h1>資料庫已建立</h1>';
    echo '<p>已建立資料庫 <strong>' . escape($db) . '</strong> 以及資料表 <strong>guestbook</strong> 和 <strong>users</strong>。</p>';
    echo '<p>請確認 `db_config.php` 中的 `$db`, `$user`, `$password` 與 MySQL 帳號密碼一致。</p>';
    echo '<p><a href="index.php">返回留言板</a></p>';
    echo '<p>若完成設定，建議移除或保護這個檔案，避免未授權使用。</p>';
} catch (PDOException $e) {
    echo '<h1>建立資料庫或資料表失敗</h1>';
    echo '<pre>' . escape($e->getMessage()) . '</pre>';
    exit;
}
