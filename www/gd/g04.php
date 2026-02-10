<?php
header("Content-Type: image/png");

// 1. 模擬資料：逐季銷售總額
$data = [
    'Q1' => 120,
    'Q2' => 250,
    'Q3' => 180,
    'Q4' => 320
];

// 2. 建立畫布與顏色
$w = 500; $h = 400;
$img = imagecreatetruecolor($w, $h);

$white = imagecolorallocate($img, 255, 255, 255);
$black = imagecolorallocate($img, 0, 0, 0);
$red   = imagecolorallocate($img, 255, 0, 0);   // 折線顏色
$gray  = imagecolorallocate($img, 230, 230, 230); // 網格顏色

imagefill($img, 0, 0, $white);

// 3. 圖表邊界與比例
$margin = 50;
$chart_w = $w - ($margin * 2);
$chart_h = $h - ($margin * 2);
$max_value = 400; // Y 軸最大刻度

// 繪製座標軸
imageline($img, $margin, $h - $margin, $w - $margin, $h - $margin, $black); // X 軸
imageline($img, $margin, $margin, $margin, $h - $margin, $black);           // Y 軸

// 4. 計算並繪製折線
$points = [];
$i = 0;
$num_items = count($data);
$x_step = $chart_w / ($num_items - 1); // 點與點之間的水平距離

foreach ($data as $label => $value) {
    // 計算當前點的 X, Y 座標
    $x = $margin + ($i * $x_step);
    $x = (int)$x;
    $y = $h - $margin - ($value / $max_value * $chart_h);
    $y = (int)$y;

    $points[$i] = ['x' => $x, 'y' => $y, 'label' => $label, 'val' => $value];
    
    // 繪製 Y 軸網格線與刻度
    imageline($img, $margin, $y, $w - $margin, $y, $gray);
    imagestring($img, 2, $margin - 35, $y - 7, $value, $black);

    // 繪製 X 軸標籤
    imagestring($img, 3, $x - 10, $h - $margin + 10, $label, $black);
    
    $i++;
}

// 5. 連結各個數據點
for ($i = 0; $i < count($points) - 1; $i++) {
    // 繪製連接線
    imagesetthickness($img, 2); // 加粗線條
    imageline($img, $points[$i]['x'], $points[$i]['y'], $points[$i+1]['x'], $points[$i+1]['y'], $red);
    imagesetthickness($img, 1); // 恢復粗度
}

// 6. 繪製數據點（小圓點）
foreach ($points as $p) {
    imagefilledellipse($img, $p['x'], $p['y'], 8, 8, $red);
}

// 標題
imagestring($img, 5, $w/2 - 60, 15, "Quarterly Sales", $black);



// 7. 輸出與銷毀
imagepng($img);
imagedestroy($img);
?>