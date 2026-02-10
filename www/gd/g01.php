<?php
// 1. 設定標頭
header("Content-Type: image/png");

// 2. 建立 200x200 的畫布
$width = 200;
$height = 200;
$image = imagecreatetruecolor($width, $height);

// 3. 配置顏色 (第一個分配的顏色通常會自動成為背景色)
$white = imagecolorallocate($image, 255, 255, 255);
$blue = imagecolorallocate($image, 0, 0, 255);

// 4. 填滿背景
imagefill($image, 0, 0, $white);

// 5. 繪製圓形 (圓心 X, 圓心 Y, 寬, 高, 顏色)
imagefilledellipse($image, 100, 100, 150, 150, $blue);

// 6. 輸出並銷毀
imagepng($image);
imagedestroy($image);
?>