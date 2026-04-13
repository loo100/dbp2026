<?php
  if (isset($_POST["album_name"]))
  {
    require_once("db_config.php");
    $album_name = $_POST["album_name"];
  	
    // 取得登入者帳號
    session_start();
    $login_user = $_SESSION["login_user"];

    try {
      // 新增相簿
      $sql = "SELECT ifnull(max(id), 0) + 1 AS album_id FROM album";
      $stmt = $pdo->query($sql);
      $album_id = $stmt->fetch(PDO::FETCH_OBJ)->album_id;

      $sql = "INSERT INTO album(id, name, owner) VALUES(?, ?, ?)";
      $stmt = $pdo->prepare($sql);
      $stmt->execute([$album_id, $album_name, $login_user]);
      
      header("location:showAlbum.php?album_id=$album_id");
    } catch (PDOException $e) {
      die("操作失敗: " . $e->getMessage());
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
    <form action="addAlbum.php" method="post">
      <table align="center">
        <tr> 
          <td> 
            相簿名稱：
          </td>
          <td>
            <input type="text" name="album_name" size="15">
            <input type="submit" value="新增">
          </td>
        </tr>
        <tr>
          <td colspan="3" align="center">
            <br><a href="index.php">回首頁</a>
          </td>	
        </tr>
      </table>
    </form>
  </body>
</html>