<?php
// 函式定義（基本）
function add($x, $y) {
    return $x + $y;
}

// 參數傳遞：Pass by Value
function increaseValue($n) {
    $n = $n + 1;
    return $n;
}

// 參數傳遞：Pass by Reference
function increaseReference(&$n) {
    $n = $n + 1;
    return $n;
}

$baseA = 5;
$baseB = 7;
$sum = add($baseA, $baseB);

$valueNum = 10;
$afterValue = increaseValue($valueNum);

$refNum = 10;
$afterRef = increaseReference($refNum);

// 匿名函式（Closure）
$anonymousAdd = function ($x, $y) {
    return $x + $y; 
};
$anonSum = $anonymousAdd(3, 4);

// 箭頭函式（Arrow Function）
$multiplier = 2;
$arrowDouble = fn ($n) => $n * $multiplier;  // 箭頭函式會自動捕獲外部變數 $multiplier
$arrowResult = $arrowDouble(6);

// 閉包（Closure）示範
$incre = 10;
$makeCounter = function ($base) use ($incre) {  // 使用 use 捕獲外部變數 $incre
    return $base + $incre;
}
?>


<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>PHP Function 示範</title>
    <style>
        body { font-family: sans-serif; background: #f4f4f4; padding: 40px; }
        .card { background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
        h1 { margin-top: 0; }
        .item { margin: 6px 0; }
        code { background: #f0f0f0; padding: 2px 6px; border-radius: 4px; }
    </style>
</head>
<body>
    <div class="card">
        <h1>PHP Function 示範</h1>

        <div class="item">基本函式 add(5, 7)：<code><?php echo $sum; ?></code></div>

        <hr>

        <div class="item">Pass by Value（原值不變）：</div>
        <div class="item">呼叫前 $valueNum = <code><?php echo $valueNum; ?></code></div>
        <div class="item">回傳 $afterValue = <code><?php echo $afterValue; ?></code></div>
        <div class="item">呼叫後 $valueNum = <code><?php echo $valueNum; ?></code></div>

        <hr>

        <div class="item">Pass by Reference（原值被修改）：</div>
        <div class="item">呼叫前 $refNum = <code><?php echo $refNum; ?></code></div>
        <div class="item">回傳 $afterRef = <code><?php echo $afterRef; ?></code></div>
        <div class="item">呼叫後 $refNum = <code><?php echo $refNum; ?></code></div>

        <hr>

        <div class="item">匿名函式：<code><?php echo $anonSum; ?></code></div>
        <div class="item">箭頭函式（乘上 2）：<code><?php echo $arrowResult; ?></code></div>
    </div>
</body>
</html>
