<?php
require_once("db_config.php");

try {
    // 篩選出所有產品資料
    $sql = "SELECT * FROM product_list";
    $stmt = $pdo->query($sql);
    $products = $stmt->fetchAll();
} catch (PDOException $e) {
    die("查詢失敗: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
  </head>	
  <body bgcolor="lightyellow">
    <table border="0" align="center" width="800" cellspacing="2"> 
      <tr bgcolor="#BABA76" height="30" align="center">
        <td>書號</td>
        <td>書名</td>
        <td>定價</td>
        <td>輸入數量</td>
        <td>進行訂購</td>																
      </tr>
        <?php
          // 列出所有產品資料
          foreach ($products as $row)
          {
            // 顯示產品各欄位的資料
            echo "<form method='post' action='add_to_car.php?book_no=" . 
              $row["book_no"] . "&book_name=" . urlencode($row["book_name"]) . 
              "&price=" . $row["price"] . "'>";
            echo "<tr align='center' bgcolor='#EDEAB1'>";
            echo "<td>" . htmlspecialchars($row["book_no"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["book_name"]) . "</td>";			
            echo "<td>$" . htmlspecialchars($row["price"]) . "</td>";
            echo "<td><input type='text' name='quantity' size='5' value='1'></td>";
            echo "<td><input type='submit' value='放入購物車'></td>";
            echo "</tr>";
            echo "</form>";
          }
        ?>
    </table>
  </body>                                                                                 
</html>