<?php
// 開啟錯誤回報方便除錯
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['myImage'])) {
    $file = $_FILES['myImage'];
    $tmpPath = $file['tmp_name'];

    // 1. 取得影像大小與格式資訊
    $imageInfo = getimagesize($tmpPath);
    if ($imageInfo === false) {
        die("這不是有效的影像檔案。");
    }

    $srcW = $imageInfo[0]; // 原始寬
    $srcH = $imageInfo[1]; // 原始高
    $mime = $imageInfo['mime']; // 影像格式 (例如 image/jpeg)

    echo "原始尺寸: {$srcW}x{$srcH} <br>";
    echo "影像格式: {$mime} <br>";

    // 2. 根據格式建立對應的來源畫布
    switch ($mime) {
        case 'image/jpeg': $srcImg = imagecreatefromjpeg($tmpPath); break;
        case 'image/png':  $srcImg = imagecreatefrompng($tmpPath);  break;
        case 'image/webp': $srcImg = imagecreatefromwebp($tmpPath); break;
        default: die("不支援的格式: $mime");
    }

    // 3. 設定縮放目標寬度，並計算等比例高度
    $targetW = 300; 
    $targetH = floor($srcH * ($targetW / $srcW));

    // 4. 建立空白的目標畫布
    $dstImg = imagecreatetruecolor($targetW, $targetH);

    // 處理透明度 (針對 PNG 和 WebP)
    if ($mime == 'image/png' || $mime == 'image/webp') {
        imagealphablending($dstImg, false);
        imagesavealpha($dstImg, true);
        $transparent = imagecolorallocatealpha($dstImg, 255, 255, 255, 127);
        imagefill($dstImg, 0, 0, $transparent);
    }

    // 5. 進行影像縮放 (Resampling)
    // 參數：目標, 來源, 目標X, 目標Y, 來源X, 來源Y, 目標寬, 目標高, 來源寬, 來源高
    imagecopyresampled($dstImg, $srcImg, 0, 0, 0, 0, $targetW, $targetH, $srcW, $srcH);

    // 6. 輸出或儲存影像 (這裡示範儲存到目錄)
    $savePath = 'uploads/thumb_' . time() . '.webp'; // 統一轉存為 WebP 節省空間
    if (!is_dir('uploads')) mkdir('uploads');
    
    imagewebp($dstImg, $savePath, 80); // 品質設定為 80

    echo "縮圖製作成功！儲存路徑: $savePath <br>";
    echo "<img src='$savePath' alt='Thumbnail'>";

    // 7. 釋放記憶體
    imagedestroy($srcImg);
    imagedestroy($dstImg);
}
?>