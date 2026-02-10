<?php
header("Content-Type: image/jpeg");

// 1. 載入現有的圖片檔
$source_img = "photo.png"; // 請確保目錄下有此檔案
$image = imagecreatefrompng($source_img);

// 2. 設定浮水印顏色 (白色)
$white = imagecolorallocate($image, 255, 255, 255);

// 3. 設定字體路徑 (請確保伺服器上有 .ttf 字體檔)
$font_path = 'C:\Windows\Fonts\arial.ttf';
$text = "Copyright © 2024 CodePartner";

// 4. 加入浮水印文字 (大小 20, 角度 0, 座標 X=10, Y=30)
// 如果沒有 TTF 字體，可改用 imagestring
imagettftext($image, 20, 0, 10, 30, $white, $font_path, $text);

// 5. 輸出圖片
imagejpeg($image);
imagedestroy($image);
?>