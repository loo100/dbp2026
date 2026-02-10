<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['my_image'])) {
    $file = $_FILES['my_image'];

    // 1. 取得檔案資訊
    $fileName = $file['name'];     // 原始檔名
    $fileTmpName = $file['tmp_name']; // 暫存路徑
    $fileSize = $file['size'];     // 檔案大小
    $fileError = $file['error'];   // 錯誤代碼

    // 2. 檢查副檔名 (安全性檢查)
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($fileExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 5000000) { // 限制 5MB
                // 3. 產生唯一檔名，避免重複覆蓋
                $newFileName = uniqid('', true) . "." . $fileExt;
                $fileDestination = 'uploads/' . $newFileName;

                // 建立資料夾 (如果不存在)
                if (!is_dir('uploads')) { mkdir('uploads'); }

                // 4. 移動檔案
                if (move_uploaded_file($fileTmpName, $fileDestination)) {
                    echo "✅ 上傳成功！檔案位置: " . $fileDestination;
                } else {
                    echo "❌ 移動檔案時出錯。";
                }
            } else { echo "❌ 檔案太大了！"; }
        } else { echo "❌ 上傳過程中發生錯誤。"; }
    } else { echo "❌ 不支援此檔案類型。"; }
}
?>