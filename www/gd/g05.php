<?php
header("Content-Type: image/png");

// 1. 模擬資料：四個產品及其銷售總額
$data = [
    'A' => 450,
    'B' => 300,
    'C' => 150,
    'D' => 100
];

$total = array_sum($data); // 總銷售額：1000

// 2. 建立畫布與顏色
$w = 500; $h = 400;
$img = imagecreatetruecolor($w, $h);

$white = imagecolorallocate($img, 255, 255, 255);
$black = imagecolorallocate($img, 0, 0, 0);
imagefill($img, 0, 0, $white); // 背景設為白色

// 配置四種產品的顏色
$colors = [
    imagecolorallocate($img, 255, 99, 132),  // 紅
    imagecolorallocate($img, 54, 162, 235), // 藍
    imagecolorallocate($img, 255, 206, 86), // 黃
    imagecolorallocate($img, 75, 192, 192)  // 綠
];

// 3. 設定圓餅圖參數
$centerX = 200; // 圓心 X
$centerY = 200; // 圓心 Y
$diameter = 300; // 直徑
$startAngle = 0; // 起始角度

// 4. 迴圈繪製各個扇形
$i = 0;
foreach ($data as $name => $value) {
    // 計算該產品佔據的角度 (金額 / 總額 * 360)
    $angle = ($value / $total) * 360;
    $endAngle = $startAngle + $angle;

    // 繪製實心扇形
    imagefilledarc(
        $img, 
        $centerX, $centerY, 
        $diameter, $diameter, 
        $startAngle, $endAngle, 
        $colors[$i], 
        IMG_ARC_PIE
    );

    // 5. 繪製圖例 (Legend)
    $lx = 380; // 圖例 X 座標
    $ly = 50 + ($i * 30); // 圖例 Y 座標
    imagefilledrectangle($img, $lx, $ly, $lx + 15, $ly + 15, $colors[$i]); // 色塊
    
    // 計算百分比並寫入文字
    $percent = round(($value / $total) * 100, 1) . '%';
    imagestring($img, 3, $lx + 25, $ly, "$name: $percent", $black);

    // 更新下一個扇形的起始角度
    $startAngle = $endAngle;
    $i++;
}

// 6. 加上圖表標題
imagestring($img, 5, 150, 20, "Sales Distribution", $black);

// 7. 輸出與清理記憶體
imagepng($img);
imagedestroy($img);
?>