<?php
  require_once("db_config.php");
  
  // 取得登入者帳號
  session_start();
  $login_user = $_SESSION["login_user"];

  try {
    if (!isset($_POST["photo_name"]))
    {
      $photo_id = $_GET["photo_id"];
    												
      // 取得相簿名稱及相簿的主人
      $sql = "SELECT a.name, a.filename, a.comment, a.album_id, b.name AS album_name,
              b.owner FROM photo a, album b where a.id = ? and b.id = a.album_id";
      $stmt = $pdo->prepare($sql);
      $stmt->execute([$photo_id]);
      $row = $stmt->fetch(PDO::FETCH_OBJ);
      $album_id = $row->album_id;
      $album_name = $row->album_name;
      $album_owner = $row->owner;
      $photo_name = $row->name;
      $file_name = $row->filename;
      $photo_comment = $row->comment;
    
      if ($album_owner != $login_user)
      {
        echo "<script type='text/javascript'>";
        echo "alert('您不是相片的主人，無法修改相片名稱。')";
        echo "</script>";
      }
    }
    else
    {
      $album_id = $_POST["album_id"];
      $photo_id = $_POST["photo_id"];
      $photo_name = $_POST["photo_name"];
      $photo_comment = $_POST["photo_comment"];
    	
      $sql = "UPDATE photo SET name = ?, comment = ?
              WHERE id = ? AND EXISTS(SELECT 1 FROM album
              WHERE id = ? AND owner = ?)";
      $stmt = $pdo->prepare($sql);
      $stmt->execute([$photo_name, $photo_comment, $photo_id, $album_id, $login_user]);
      
      header("location:showAlbum.php?album_id=$album_id");
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
    <form action="editPhoto.php" method="post">
      <table align="center">
        <tr> 
          <td> 
            相片名稱：
          </td>
          <td>
            <input type="text" name="photo_name" size="31"
              value="<?php echo $photo_name ?>">
          </td>
        </tr>
        <tr> 
          <td> 
            相片描述：
          </td>
          <td>
            <textarea name="photo_comment" rows="5" cols="25"><?php echo $photo_comment ?></textarea>
            <input type="hidden" name="photo_id" value="<?php echo $photo_id ?>">
            <input type="hidden" name="album_id" value="<?php echo $album_id ?>">
            <input type="submit" value="更新"
              <?php if ($album_owner != $login_user) echo 'disabled' ?>>
          </td>
        </tr>
        <tr>
          <td colspan="2" align="center">
            <br><a href="showAlbum.php?album_id=<?php echo $album_id ?>">
              回【<?php echo $album_name ?>】相簿</a>
          </td>	
        </tr>
      </table>
    </form>
  </body>
</html>