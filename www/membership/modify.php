<?php
  //檢查 cookie 中的 passed 變數是否等於 TRUE
  // 
  // 
  $passed = $_COOKIE["passed"];

  if ($passed != "TRUE")
  {
    header("location: login.html");
    exit();
  }

  //如果 cookie 中的 passed 變數等於 TRUE
  //表示已經登入網站，取得使用者資料
  else
  {
    require_once("db_config.php");

    $id = $_COOKIE["id"];

    //執行 SELECT 陳述式取得使用者資料
    $sql = "SELECT * FROM members2 WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html>
  <head>
    <title>修改會員資料</title>
    <meta charset="utf-8">
  </head>
  <body>
    <p align="center"><img src="modify.jpg"></p>
    <form name="myForm" method="post" action="update.php" >
      <table border="2" align="center" bordercolor="#6666FF">
        <tr>
          <td colspan="2" bgcolor="#6666FF" align="center">
            <font color="#FFFFFF">請填入下列資料 (標示「*」欄位請務必填寫)</font>
          </td>
        </tr>
        <tr bgcolor="#99FF99">
          <td align="right">*使用者帳號：</td>
          <td><?php echo $row["account"] ?></td>
        </tr>
        <tr bgcolor="#99FF99">
          <td align="right">*使用者密碼：</td>
          <td>
            <input type="password" name="password" size="15" value="<?php echo $row["password"] ?>">
            (請使用英文或數字鍵，勿使用特殊字元)
          </td>
        </tr>
        <tr bgcolor="#99FF99">
          <td align="right">*密碼確認：</td>
          <td>
            <input type="password" name="re_password" size="15" value="<?php echo $row["password"] ?>">
            (再輸入一次密碼，並記下您的使用者名稱與密碼)
          </td>
        </tr>
        <tr bgcolor="#99FF99">
          <td align="right">*姓名：</td>
          <td><input type="text" name="name" size="8" value="<?php echo $row["name"] ?>"></td>
        </tr>
        <tr bgcolor="#99FF99">
          <td align="right">*性別：</td>
          <td>
            <input type="radio" name="sex" value="男" checked>男
            <input type="radio" name="sex" value="女">女
          </td>
        </tr>
        <tr bgcolor="#99FF99">
          <td align="right">*生日：</td>
          <td>民國
            <input type="text" name="year" size="2" value="<?php echo $row["year"] ?>">年
            <input type="text" name="month" size="2" value="<?php echo $row["month"] ?>">月
            <input type="text" name="day" size="2" value="<?php echo $row["day"] ?>">日
          </td>
        </tr>
        <tr bgcolor="#99FF99">
          <td align="right">電話：</td>
          <td>
            <input type="text" name="telephone" size="20" value="<?php echo $row["telephone"] ?>">
            (依照 (02) 2311-3836 格式 or (04) 657-4587)
          </td>
        </tr>
        <tr bgcolor="#99FF99">
          <td align="right">行動電話：</td>
          <td>
            <input type="text" name="cellphone" size="20" value="<?php echo $row["cellphone"] ?>">
            (依照 (0922) 302-228 格式)
          </td>
        </tr>
        <tr bgcolor="#99FF99">
          <td align="right">地址：</td>
          <td><input type="text" name="address" size="45" value="<?php echo $row["address"] ?>"></td>
        </tr>
        <tr bgcolor="#99FF99">
          <td align="right">E-mail 帳號：</td>
          <td><input type="text" name="email" size="30" value="<?php echo $row["email"] ?>"></td>
        </tr>
        <tr bgcolor="#99FF99">
          <td align="right">個人網站：</td>
          <td><input type="text" name="url" size="40" value="<?php echo $row["url"] ?>"></td>
        </tr>
        <tr bgcolor="#99FF99">
          <td align="right">備註：</td>
          <td><textarea name="comment" rows="4" cols="45"><?php echo $row["comment"] ?></textarea></td>
        </tr>
        <tr bgcolor="#99FF99">
          <td colspan="2" align="CENTER">
            <input type="submit" value="修改資料">
            <input type="reset" value="重新填寫">
          </td>
        </tr>
      </table>
    </form>
  </body>
</html>
<?php
  }
?>