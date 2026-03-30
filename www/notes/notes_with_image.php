<?php
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }
require 'db.php';

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'] ?? '使用者';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_note'])) {
    $content = trim($_POST['content']);
    $image_path = null;

    // --- 圖片處理邏輯 ---
    if (!empty($_FILES['attachment']['name'])) {
        $file = $_FILES['attachment'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($ext, $allowed) && $file['size'] < 20000000) { // 限制 20MB
            $newName = uniqid('IMG_', true) . "." . $ext;
            if (!is_dir('uploads')) { mkdir('uploads'); }
            
            $dest = 'uploads/' . $newName;
            if (move_uploaded_file($file['tmp_name'], $dest)) {
                $image_path = $dest; // 上傳成功，記錄路徑
            }
        } else {
            $error = "圖片格式不符或檔案過大（限制 20MB）";
        }
    }

    // --- 存入資料庫 (新增了 image_path) ---
    if (!empty($content) || $image_path) {
        try {
            $stmt = $pdo->prepare("INSERT INTO notes (user_id, content, image_path) VALUES (?, ?, ?)");
            $stmt->execute([$user_id, $content, $image_path]);
            $success = "筆記已保存！";
        } catch (PDOException $e) {
            $error = "保存失敗: " . $e->getMessage();
        }
    } else {
        $error = "筆記內容和圖片不能同時為空";
    }
}

// 讀取資料
try {
    $stmt = $pdo->prepare("SELECT id, content, image_path, created_at, updated_at FROM notes WHERE user_id = ? ORDER BY created_at DESC");
    $stmt->execute([$user_id]);
    $my_notes = $stmt->fetchAll();
} catch (PDOException $e) {
    $error = "讀取失敗: " . $e->getMessage();
    $my_notes = [];
}
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>圖文筆記本</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <span class="navbar-brand">📝 圖文筆記本</span>
            <div class="ms-auto">
                <span class="text-white me-3">歡迎，<?php echo htmlspecialchars($username); ?></span>
                <a href="logout.php" class="btn btn-danger btn-sm">登出</a>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <div class="card shadow-sm mx-auto" style="max-width: 600px;">
            <div class="card-body">
                <h4>📝 新增圖文筆記</h4>

                <?php if ($success ?? false): ?>
                    <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
                <?php endif; ?>

                <?php if ($error ?? false): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>

                <form method="POST" enctype="multipart/form-data">
                    <textarea name="content" class="form-control mb-2" placeholder="寫點什麼..." rows="4"></textarea>
                    <div class="mb-3">
                        <label class="form-label">附件圖片 (選擇性)</label>
                        <input type="file" name="attachment" class="form-control" accept="image/*">
                    </div>
                    <button type="submit" name="add_note" class="btn btn-primary w-100">儲存</button>
                </form>

                <hr>

                <h5>🗂 我的筆記</h5>
                <?php if (empty($my_notes)): ?>
                    <p class="text-muted text-center my-5">還沒有筆記，開始記錄吧！</p>
                <?php else: ?>
                    <?php foreach ($my_notes as $note): ?>
                        <div class="border-bottom py-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div style="flex: 1;">
                                    <p class="mb-1"><?php echo nl2br(htmlspecialchars($note['content'])); ?></p>
                                    
                                    <?php if ($note['image_path']): ?>
                                        <div class="mb-2">
                                            <img src="<?php echo htmlspecialchars($note['image_path']); ?>" class="img-fluid rounded" style="max-height: 200px;">
                                        </div>
                                    <?php endif; ?>
                                    
                                    <small class="text-muted">
                                        建立時間：<?php echo $note['created_at']; ?>
                                        <?php if ($note['updated_at'] !== $note['created_at']): ?>
                                            <br>修改時間：<?php echo $note['updated_at']; ?>
                                        <?php endif; ?>
                                    </small>
                                </div>
                                <a href="delete_note.php?id=<?php echo $note['id']; ?>" class="btn btn-sm btn-danger ms-2" onclick="return confirm('確認刪除此筆記？');">刪除</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>