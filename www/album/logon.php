<?php
  if (isset($_POST["account"]))
  {
    require_once("db_config.php");
		
    // 取得登入資料
    $login_user = $_POST["account"]; 	
    $login_password = $_POST["password"];

    try {
      // 檢查帳號密碼是否正確
      $sql = "SELECT account, name FROM user Where account = ? AND password = ?";
      $stmt = $pdo->prepare($sql);
      $stmt->execute([$login_user, $login_password]);
      
      // 若沒找到資料，表示帳號密碼錯誤
      if ($stmt->rowCount() == 0)
      {
        // 顯示訊息要求使用者輸入正確的帳號密碼
        echo "<script type='text/javascript'>alert('帳號密碼錯誤，請查明後再登入')</script>";
      }
      else     // 如果帳號密碼正確
      {
        // 將使用者資料加入 Session
        session_start();
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        $_SESSION["login_user"] = $row->account;
        $_SESSION["login_name"] = $row->name;
          
        header("location:index.php");
      }
    } catch (PDOException $e) {
      die("登入失敗: " . $e->getMessage());
    }
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>電子相簿</title>
  </head>
  <body>
    <p align="center"><img src="Title.png"></p>
    <form action="logon.php" method="post" name="myForm">
      <table align="center">
        <tr> 
          <td> 
            帳號：
          </td>
          <td>
            <input type="text" name="account" size="15">
          </td>
        </tr>
        <tr> 
          <td> 
            密碼：
          </td>
          <td>
            <input type="password"name="password" size="15">
          </td>
        </tr>
        <tr>
          <td align="center" colspan="2"> 
            <input type="submit" value="登入">
            <input type="reset" value="重填">
          </td>
        </tr>
      </table>
    </form>
  </body>
</html>