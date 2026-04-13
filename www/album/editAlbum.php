<?php
  require_once("db_config.php");
  
  // 取得登入者帳號
  session_start();
  $login_user = $_SESSION["login_user"];

  try {
    if (!isset($_POST["album_id"]))
    {
      $album_id = $_GET["album_id"];
    												
      // 取得相簿名稱及相簿所有者的帳號
      $sql = "SELECT name, owner FROM album where id = ?";
      $stmt = $pdo->prepare($sql);
      $stmt->execute([$album_id]);
      $row = $stmt->fetch(PDO::FETCH_OBJ);
      $album_name = $row->name;
      $album_owner = $row->owner;
    
      if ($album_owner != $login_user)
      {
        echo "<script type='text/javascript'>";
        echo "alert('您不是相簿的主人，無法修改相簿名稱。$album_owner');";
        echo "</script>";
      }
    }
    else
    {
      $album_id = $_POST["album_id"];
      $album_name = $_POST["album_name"];
      
      $sql = "UPDATE album SET name = ? WHERE id = ? AND owner = ?";
      $stmt = $pdo->prepare($sql);
      $stmt->execute([$album_name, $album_id, $login_user]);
      
      header("location:index.php");
    }
  } catch (PDOException $e) {
    die("操作失敗: " . $e->getMessage());
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
    <form action="editAlbum.php" method="post">
      <table align="center">
        <tr> 
          <td> 
            相簿名稱：
          </td>
          <td>
            <input type="text" name="album_name" size="15"
              value="<?php echo $album_name ?>">
            <input type="hidden" name="album_id" value="<?php echo $album_id ?>">
            <input type="submit" value="更新"
              <?php if ($album_owner != $login_user) echo 'disabled' ?>>
          </td>
        </tr>
        <tr>
          <td colspan="2" align="center">
            <br><a href="index.php">回首頁</a>
          </td>	
        </tr>
      </table>
    </form>
  </body>
</html>