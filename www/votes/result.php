<?php
require 'db_config.php';

// 定義圖表類型
$chart_type = $_GET['type'] ?? 'bar'; // 'bar' 或 'pie'

try {
    // 獲取投票統計資料
    $stats_stmt = $pdo->query("
        SELECT c.id, c.name, COUNT(v.id) as vote_count
        FROM candidates c
        LEFT JOIN votes v ON c.id = v.candidate_id
        GROUP BY c.id, c.name
        ORDER BY vote_count DESC
    ");
    $stats = $stats_stmt->fetchAll();

    // 計算總票數
    $total_votes = array_sum(array_column($stats, 'vote_count'));

} catch (PDOException $e) {
    die("資料庫查詢失敗: " . $e->getMessage());
}

// 生成圖表圖片
function generateChart($stats, $total_votes, $type) {
    if (empty($stats)) {
        return null;
    }

    if ($type == 'pie') {
        return generatePieChart($stats);
    } else {
        return generateBarChart($stats);
    }
}

// 生成直條圖
function generateBarChart($stats) {
    $width = 800;
    $height = 500;
    $padding = 60;
    $img = imagecreatetruecolor($width, $height);

    // 定義顏色
    $colors = [
        'white' => imagecolorallocate($img, 255, 255, 255),
        'black' => imagecolorallocate($img, 0, 0, 0),
        'gray' => imagecolorallocate($img, 200, 200, 200),
        'blue' => imagecolorallocate($img, 102, 126, 234),
        'purple' => imagecolorallocate($img, 118, 75, 162),
    ];

    // 背景
    imagefilledrectangle($img, 0, 0, $width, $height, $colors['white']);

    // 邊框
    imagerectangle($img, 1, 1, $width - 2, $height - 2, $colors['gray']);

    // 標題
    $title = "Result - Bar Chart";
    imagestring($img, 5, 260, 20, $title, $colors['black']);

    // 取得最大投票數
    $max_votes = max(array_column($stats, 'vote_count'));
    if ($max_votes == 0) $max_votes = 1;

    // 繪製直條
    $num_items = count($stats);
    $item_width = ($width - 2 * $padding) / $num_items;
    $chart_height = $height - 2 * $padding - 40;

    foreach ($stats as $index => $item) {
        $x = (int) round($padding + $index * $item_width);
        $bar_left = (int) round($x + $item_width * 0.1);
        $bar_right = (int) round($x + $item_width * 0.9);
        $bar_height = (int) round(($item['vote_count'] / $max_votes) * $chart_height);
        $y = (int) round($height - $padding + 20 - $bar_height);

        // 繪製直條
        $color = ($index % 2 == 0) ? $colors['blue'] : $colors['purple'];
        imagefilledrectangle($img, $bar_left, $y, $bar_right, $height - $padding + 20, $color);

        // 標籤
        $text = (string) $item['vote_count'];
        imagestring($img, 4, $x + (int) round($item_width * 0.25), $y - 20, $text, $colors['black']);
    }

    // Y軸標籤
    for ($i = 0; $i <= 5; $i++) {
        $y = (int) round($height - $padding + 20 - ($i / 5) * $chart_height);
        $value = (int) round($max_votes * $i / 5);
        imagestring($img, 2, $padding - 40, $y - 5, (string) $value, $colors['black']);
    }

    // X軸
    imageline($img, $padding, $height - $padding + 20, $width - $padding, $height - $padding + 20, $colors['black']);

    // Y軸
    imageline($img, $padding, $padding, $padding, $height - $padding + 20, $colors['black']);

    return $img;
}

// 生成圓餅圖
function generatePieChart($stats) {
    $width = 600;
    $height = 600;
    $img = imagecreatetruecolor($width, $height);

    // 定義顏色
    $colors = [
        'white' => imagecolorallocate($img, 255, 255, 255),
        'black' => imagecolorallocate($img, 0, 0, 0),
        'gray' => imagecolorallocate($img, 200, 200, 200),
    ];

    // 色盤
    $pie_colors = [
        imagecolorallocate($img, 102, 126, 234),
        imagecolorallocate($img, 118, 75, 162),
        imagecolorallocate($img, 255, 107, 107),
        imagecolorallocate($img, 255, 193, 7),
        imagecolorallocate($img, 76, 175, 80),
        imagecolorallocate($img, 33, 150, 243),
    ];

    // 背景
    imagefilledrectangle($img, 0, 0, $width, $height, $colors['white']);

    // 標題
    imagestring($img, 5, 200, 20, "Result - Pie Chart", $colors['black']);

    // 計算總票數
    $total_votes = array_sum(array_column($stats, 'vote_count'));
    if ($total_votes == 0) {
        imagestring($img, 4, 200, 300, "No votes yet", $colors['black']);
        return $img;
    }

    // 繪製圓餅
    $cx = $width / 2;
    $cy = $height / 2 + 20;
    $radius = 150;
    $start_angle = 0;
    $start_x = $cx + $radius;
    $start_y = $cy;

    // 計算角度並處理小數點，確保總角度為 360
    $angles = [];
    $angle_sum = 0;
    foreach ($stats as $item) {
        $raw_angle = ($item['vote_count'] / $total_votes) * 360;
        $angle = (int) floor($raw_angle);
        $angles[] = $angle;
        $angle_sum += $angle;
    }
    if ($angle_sum < 360 && count($angles) > 0) {
        $angles[count($angles) - 1] += (360 - $angle_sum);
    }

    foreach ($stats as $index => $item) {
        $percent = $item['vote_count'] / $total_votes;
        $angle = $angles[$index];
        $color = $pie_colors[$index % count($pie_colors)];

        // 繪製扇形
        imagefilledarc($img, $cx, $cy, $radius * 2, $radius * 2, $start_angle, $start_angle + $angle, $color, IMG_ARC_PIE);

        // 計算標籤位置
        $label_angle = $start_angle + ($angle / 2);
        $label_x = $cx + cos(deg2rad($label_angle)) * ($radius * 0.6);
        $label_y = $cy + sin(deg2rad($label_angle)) * ($radius * 0.6);

        // 繪製百分比
        $percent_text = number_format($percent * 100, 1) . '%';
        imagestring($img, 3, (int) round($label_x - 12), (int) round($label_y - 6), $percent_text, $colors['white']);

        $start_angle += $angle;
    }

    return $img;
}

// 根據選擇的圖表類型生成圖片
if (!empty($stats)) {
    $chart_img = generateChart($stats, $total_votes, $chart_type);
}
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>投票結果統計</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Microsoft JhengHei', Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 40px 20px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            color: white;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 36px;
            margin-bottom: 10px;
        }

        .chart-section {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            margin-bottom: 30px;
        }

        .chart-controls {
            text-align: center;
            margin-bottom: 30px;
        }

        .chart-controls a {
            display: inline-block;
            margin: 0 10px;
            padding: 12px 25px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .chart-controls a:hover {
            background: #764ba2;
            transform: translateY(-2px);
        }

        .chart-controls a.active {
            background: #764ba2;
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }

        .chart-image {
            text-align: center;
            margin: 20px 0;
        }

        .chart-image img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }

        .no-data {
            text-align: center;
            color: #999;
            padding: 50px 20px;
            font-size: 18px;
        }

        .stats-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        .stats-table thead {
            background: #f8f9fa;
        }

        .stats-table th,
        .stats-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .stats-table thead th {
            font-weight: 600;
            color: #333;
        }

        .stats-table tbody tr:hover {
            background: #f8f9fa;
        }

        .progress-bar {
            width: 100%;
            height: 25px;
            background: #e0e0e0;
            border-radius: 3px;
            overflow: hidden;
            margin: 10px 0;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 12px;
            font-weight: 600;
        }

        .nav-buttons {
            text-align: center;
            margin-top: 30px;
        }

        .nav-buttons a {
            display: inline-block;
            margin: 0 10px;
            padding: 12px 25px;
            background: white;
            color: #667eea;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .nav-buttons a:hover {
            background: #f0f0f0;
            transform: translateY(-2px);
        }

        .total-votes {
            text-align: center;
            color: #667eea;
            font-size: 18px;
            font-weight: 600;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📊 投票結果統計</h1>
            <p>查看投票的即時統計結果</p>
        </div>

        <div class="chart-section">
            <div class="chart-controls">
                <a href="result.php?type=bar" class="<?php echo $chart_type == 'bar' ? 'active' : ''; ?>">📊 直條圖</a>
                <a href="result.php?type=pie" class="<?php echo $chart_type == 'pie' ? 'active' : ''; ?>">🥧 圓餅圖</a>
            </div>

            <?php if (empty($stats) || $total_votes == 0): ?>
                <div class="no-data">
                    目前還沒有投票記錄，<br>
                    <a href="index.php" style="color: #667eea; text-decoration: none;">返回投票→</a>
                </div>
            <?php else: ?>
                <?php if (isset($chart_img)): ?>
                    <div class="chart-image">
                        <?php
                        // 輸出圖表為臨時文件
                        $temp_file = tempnam(sys_get_temp_dir(), 'chart_') . '.png';
                        imagepng($chart_img, $temp_file);
                        imagedestroy($chart_img);
                        ?>
                        <img src="data:image/png;base64,<?php echo base64_encode(file_get_contents($temp_file)); ?>" alt="投票統計圖表">
                        <?php unlink($temp_file); ?>
                    </div>
                <?php endif; ?>

                <div class="total-votes">
                    總票數：<?php echo $total_votes; ?>
                </div>

                <table class="stats-table">
                    <thead>
                        <tr>
                            <th>排名</th>
                            <th>項目名稱</th>
                            <th>票數</th>
                            <th>百分比</th>
                            <th>進度條</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($stats as $index => $item): ?>
                            <tr>
                                <td><strong><?php echo $index + 1; ?></strong></td>
                                <td><?php echo htmlspecialchars($item['name']); ?></td>
                                <td><?php echo $item['vote_count']; ?></td>
                                <td><?php echo round(($item['vote_count'] / $total_votes) * 100, 1); ?>%</td>
                                <td>
                                    <div class="progress-bar">
                                        <div class="progress-fill" style="width: <?php echo ($item['vote_count'] / $total_votes) * 100; ?>%;">
                                            <?php echo round(($item['vote_count'] / $total_votes) * 100, 0); ?>%
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>

        <div class="nav-buttons">
            <a href="index.php">🗳️ 返回投票</a>
            <a href="recommend.html">➕ 新增項目</a>
        </div>
    </div>
</body>
</html>
