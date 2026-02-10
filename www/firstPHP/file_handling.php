<?php
// File handling demo for PHP (paths, directories, files, read/write).

header('Content-Type: text/html; charset=utf-8');

$baseDir = __DIR__ . DIRECTORY_SEPARATOR . 'file_demo';
$demoFile = $baseDir . DIRECTORY_SEPARATOR . 'notes.txt';

$messages = [];

// 1) Access server-side paths
$messages[] = "Current script dir: " . __DIR__;
$messages[] = "Server working dir: " . getcwd();

// 2) Access server-side folder
if (!is_dir($baseDir)) {
    $created = mkdir($baseDir, 0775, true);
    $messages[] = $created ? "Created folder: $baseDir" : "Failed to create folder: $baseDir";
} else {
    $messages[] = "Folder exists: $baseDir";
}

// 3) Access server-side files (create/write)
$content = "Hello from PHP file handling\n";
$content .= "Timestamp: " . date('Y-m-d H:i:s') . "\n";
$content .= "Path: $demoFile\n";

$bytesWritten = file_put_contents($demoFile, $content, LOCK_EX);
$messages[] = $bytesWritten !== false
    ? "Wrote $bytesWritten bytes to file: $demoFile"
    : "Failed to write file: $demoFile";

// 4) Read server-side text file
if (file_exists($demoFile)) {
    $fileText = file_get_contents($demoFile);
    $messages[] = "Read file content successfully.";
} else {
    $fileText = "(File not found)";
    $messages[] = "File not found: $demoFile";
}

// 5) List files in the folder
$files = scandir($baseDir);

function escape($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
?>
<!doctype html>
<html lang="zh-Hant">
<head>
    <meta charset="utf-8">
    <title>PHP 檔案處理範例</title>
    <style>
        body { font-family: system-ui, -apple-system, "Segoe UI", Arial, sans-serif; margin: 24px; }
        h1 { margin-bottom: 12px; }
        pre { background: #f4f4f4; padding: 12px; border-radius: 6px; }
        ul { padding-left: 20px; }
    </style>
</head>
<body>
    <h1>PHP 檔案處理範例</h1>

    <h2>操作結果</h2>
    <ul>
        <?php foreach ($messages as $msg): ?>
            <li><?= escape($msg) ?></li>
        <?php endforeach; ?>
    </ul>

    <h2>檔案內容</h2>
    <pre><?= escape($fileText) ?></pre>

    <h2>資料夾清單</h2>
    <pre><?= escape(implode("\n", $files)) ?></pre>
</body>
</html>
