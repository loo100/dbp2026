<?php
require 'db.php';

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';
    $email = $_POST['email'] ?? '';

    // 驗證
    if (empty($username) || empty($password)) {
        $error = "帳號和密碼不能為空";
    } elseif ($password !== $password_confirm) {
        $error = "兩次輸入的密碼不相同";
    } elseif (strlen($password) < 6) {
        $error = "密碼至少需要 6 個字符";
    } else {
        try {
            // 檢查帳號是否已存在
            $check_stmt = $pdo->prepare("SELECT id FROM noteusers WHERE username = ?");
            $check_stmt->execute([$username]);
            
            if ($check_stmt->rowCount() > 0) {
                $error = "此帳號已被註冊";
            } else {
                // 插入新使用者
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO noteusers (username, password, email) VALUES (?, ?, ?)");
                $stmt->execute([$username, $hashed_password, $email]);

                $success = "註冊成功！請 <a href='login.php'>登入</a>";
            }
        } catch (PDOException $e) {
            $error = "註冊失敗: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>註冊</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="card shadow-sm mx-auto" style="max-width: 400px;">
            <div class="card-body">
                <h4 class="text-center mb-4">📝 圖文筆記本註冊</h4>

                <?php if ($error): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                <?php elseif ($success): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">帳號</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">密碼</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">確認密碼</label>
                        <input type="password" name="password_confirm" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">信箱 (選擇性)</label>
                        <input type="email" name="email" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">註冊</button>
                </form>

                <hr>
                <p class="text-center">已有帳號？ <a href="login.php">點此登入</a></p>
            </div>
        </div>
    </div>
</body>
</html>
