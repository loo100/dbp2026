<?php
// 基本型別
$intNum = 42;                // 整數
$floatNum = 3.14;            // 浮點數
$isActive = true;            // 布林
$text = "Hello PHP";         // 字串
$nothing = null;             // 空值

// 變數與運算子
$a = 10;
$b = 3;

$sum = $a + $b;              // 加法
$diff = $a - $b;             // 減法
$product = $a * $b;          // 乘法
$quotient = $a / $b;         // 除法
$mod = $a % $b;              // 取餘數

$isEqual = ($a == $b);       // 相等
$isSame = ($a === $b);       // 全等
$isGreater = ($a > $b);      // 大於
$logic = ($a > 5 && $b < 5); // 邏輯運算

$concat = $text . " !!!";   // 字串串接
$a += 5;                      // 指派運算

// 型別轉換（Type Casting）
$toInt = (int)$floatNum;       // 浮點數轉整數
$toFloat = (float)$intNum;     // 整數轉浮點數
$toString = (string)$intNum;   // 整數轉字串
$toBool = (bool)$intNum;       // 整數轉布林

// 常用預先定義常數
$phpVersion = PHP_VERSION;
$phpOs = PHP_OS;
$phpIntMax = PHP_INT_MAX;
$dirSep = DIRECTORY_SEPARATOR;
$thisFile = __FILE__;
$thisLine = __LINE__;
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>PHP 基本語法示範</title>
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
        <h1>PHP 基本語法示範</h1>
        <div class="item">整數：<code><?php echo $intNum; ?></code></div>
        <div class="item">浮點數：<code><?php echo $floatNum; ?></code></div>
        <div class="item">布林：<code><?php echo $isActive ? 'true' : 'false'; ?></code></div>
        <div class="item">字串：<code><?php echo $text; ?></code></div>
        <div class="item">空值：<code><?php echo $nothing; ?></code></div>

        <hr>

        <div class="item">$a + $b = <code><?php echo $sum; ?></code></div>
        <div class="item">$a - $b = <code><?php echo $diff; ?></code></div>
        <div class="item">$a * $b = <code><?php echo $product; ?></code></div>
        <div class="item">$a / $b = <code><?php echo $quotient; ?></code></div>
        <div class="item">$a % $b = <code><?php echo $mod; ?></code></div>

        <hr>

        <div class="item">$a == $b：<code><?php echo $isEqual ? 'true' : 'false'; ?></code></div>
        <div class="item">$a === $b：<code><?php echo $isSame ? 'true' : 'false'; ?></code></div>
        <div class="item">$a > $b：<code><?php echo $isGreater ? 'true' : 'false'; ?></code></div>
        <div class="item">$a > 5 且 $b < 5：<code><?php echo $logic ? 'true' : 'false'; ?></code></div>

        <hr>

        <div class="item">字串串接：<code><?php echo $concat; ?></code></div>
        <div class="item">指派後 $a：<code><?php echo $a; ?></code></div>

        <hr>

        <div class="item">(int)$floatNum：<code><?php echo $toInt; ?></code></div>
        <div class="item">(float)$intNum：<code><?php echo $toFloat; ?></code></div>
        <div class="item">(string)$intNum：<code><?php echo $toString; ?></code></div>
        <div class="item">(bool)$intNum：<code><?php echo $toBool ? 'true' : 'false'; ?></code></div>

        <hr>

        <div class="item">PHP_VERSION：<code><?php echo $phpVersion; ?></code></div>
        <div class="item">PHP_OS：<code><?php echo $phpOs; ?></code></div>
        <div class="item">PHP_INT_MAX：<code><?php echo $phpIntMax; ?></code></div>
        <div class="item">DIRECTORY_SEPARATOR：<code><?php echo $dirSep; ?></code></div>
        <div class="item">__FILE__：<code><?php echo $thisFile; ?></code></div>
        <div class="item">__LINE__：<code><?php echo $thisLine; ?></code></div>
    </div>
</body>
</html>
