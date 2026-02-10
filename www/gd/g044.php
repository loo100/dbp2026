<?php
header("Content-Type: image/png");

// 1. 模擬資料
$data = [
    'Prod A' => 450,
    'Prod B' => 300,
    'Prod C' => 150,
    'Prod D' => 100
];

// 2. 建立畫布
$w = 500; $h = 400;
$img = imagecreatetruecolor($w, $h);

// 配置顏色
$white = imagecolorallocate($img, 255, 255, 255);
$black = imagecolorallocate($img, 0, 0, 0);
$gray  = imagecolorallocate($img, 200, 200, 200);
$blue  = imagecolorallocate($img, 54, 162, 235); // 長條顏色

imagefill($img, 0, 0, $white);

// 3. 定義圖表邊界 (留出空間寫標籤)
$margin = 50;
$chart_w = $w - ($margin * 2);
$chart_h = $h - ($margin * 2);
$max_value = 500; // 假設 Y 軸最大值為 500

// 繪製 X 軸與 Y 軸
imageline($img, $margin, $h - $margin, $w - $margin, $h - $margin, $black); // X 軸
imageline($img, $margin, $margin, $margin, $h - $margin, $black);           // Y 軸

// 4. 繪製長條與標籤
$bar_gap = 20; // 條形之間的間距
$num_items = count($data);
$bar_width = ($chart_w - ($bar_gap * ($num_items + 1))) / $num_items;

$i = 0;
foreach ($data as $name => $value) {
    // 計算座標
    // x1 = 左邊界 + 間距 + (第幾根 * (寬度+間距))
    $x1 = $margin + $bar_gap + ($i * ($bar_width + $bar_gap));
    $y1 = $h - $margin - ($value / $max_value * $chart_h); // 根據比例算高度
    $x2 = $x1 + $bar_width;
    $y2 = $h - $margin;
    $x1 = (int)$x1;
    $y1 = (int)$y1;
    $x2 = (int)$x2;
    $y2 = (int)$y2;
    // 繪製長條
    imagefilledrectangle($img, $x1, $y1, $x2, $y2, $blue);
    
    // 繪製數值 (在長條上方)
    $a = $x1 + ($bar_width/4);
    $a = (int)$a;
    imagestring($img, 3, $a, $y1 - 15, $value, $black);
    
    // 繪製產品名稱 (在 X 軸下方)
    imagestring($img, 3, $x1, $h - $margin + 10, $name, $black);

    $i++;
}

// 5. 繪製 Y 軸刻度 (簡單標示)
for ($j = 0; $j <= $max_value; $j += 100) {
    $y_pos = $h - $margin - ($j / $max_value * $chart_h);
    $y_pos = (int)$y_pos;
    imageline($img, $margin - 5, $y_pos, $margin, $y_pos, $black); // 刻度線
    imagestring($img, 2, $margin - 30, $y_pos - 7, $j, $black);    // 刻度值
}

// 標題
imagestring($img, 5, $w/2 - 50, 10, "Sales Statistics", $black);



// 6. 輸出
imagepng($img);
imagedestroy($img);
?>