<?php
session_start();
header("Content-Type: image/png");

$code = rand(1000, 9999); // 產生隨機 4 位數
$_SESSION['captcha'] = $code;

$img = imagecreatetruecolor(100, 40);
$bg = imagecolorallocate($img, 220, 220, 220); // 淺灰色背景
$textColor = imagecolorallocate($img, 0, 0, 0); // 黑色文字
$noiseColor = imagecolorallocate($img, 100, 100, 100); // 噪點顏色

imagefill($img, 0, 0, $bg);

// 加入一些干擾線點，增加辨識難度
for($i=0; $i<150; $i++) {
    imagesetpixel($img, rand(0,100), rand(0,40), $noiseColor);
}

// 寫入文字 (使用內建字體 5)
imagestring($img, 5, 30, 12, $code, $textColor);

imagepng($img);
imagedestroy($img);
?>