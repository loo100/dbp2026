<?php
header('Content-Type: text/html; charset=utf-8');

$name = isset($_GET['name']) ? htmlspecialchars($_GET['name']) : '訪客';

echo "你好，$name ！歡迎使用 AJAX。";
?>