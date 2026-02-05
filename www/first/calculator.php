<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>PHP 簡易計算器</title>
    <style>
        body { font-family: sans-serif; display: flex; justify-content: center; padding-top: 50px; }
        .card { border: 1px solid #ddd; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        input { padding: 8px; width: 60px; margin: 5px; }
        button { padding: 8px 15px; cursor: pointer; background: #007bff; color: white; border: none; border-radius: 4px; }
        .result { margin-top: 15px; font-size: 1.2em; color: #28a745; font-weight: bold; }
        select { padding: 8px; margin: 5px; }
    </style>
</head>
<body>

<div class="card">
    <h2>➕ 計算器</h2>
    
    <form method="POST" action="">
        <input type="number" name="num1" placeholder="數字 1" required>
        <select name="operator" required>
            <option value="+">+</option>
            <option value="-">-</option>
            <option value="*">*</option>
            <option value="/">/</option>
        </select>
        <input type="number" name="num2" placeholder="數字 2" required>
        <button type="submit" name="calculate">計算</button>
    </form>

    <div class="result">
        <?php
        // PHP 邏輯部分
        if (isset($_POST['calculate'])) {
            // 1. 接收資料 (從 $_POST 取得輸入框的值)
            $n1 = $_POST['num1'];
            $n2 = $_POST['num2'];
            $operator = $_POST['operator'];

            // 2. 進行邏輯運算
            $result = null;
            switch ($operator) {
                case '+':
                    $result = $n1 + $n2;
                    break;
                case '-':
                    $result = $n1 - $n2;
                    break;
                case '*':
                    $result = $n1 * $n2;
                    break;
                case '/':
                    if ($n2 != 0) {
                        $result = $n1 / $n2;
                    } else {
                        $result = "錯誤：除數不能為 0";
                    }
                    break;
                default:
                    $result = "無效的運算符號";
            }

            // 3. 輸出結果
            if (is_numeric($result)) {
                echo "計算結果：$n1 $operator $n2 = $result";
            } else {
                echo $result;
            }
        }
        ?>
    </div>
</div>

</body>
</html>