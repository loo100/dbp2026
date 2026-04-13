<?php
  require_once("db_config.php");
  
  $album_id = $_GET["album_id"];
  
  // 取得登入者帳號
  session_start();
  $login_user = $_SESSION["login_user"];

  try {
    // 刪除儲存在硬碟的相片
    $sql = "SELECT filename FROM photo WHERE album_id = ?
            AND EXISTS(SELECT 1 FROM album WHERE id = ? AND owner = ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$album_id, $album_id, $login_user]);
    $photos = $stmt->fetchAll();
    
    foreach ($photos as $row)
    {
      $file_name = $row["filename"];
      $photo_path = realpath("./Photo/$file_name");
      $thumbnail_path = realpath("./Thumbnail/$file_name");

      if (file_exists($photo_path))
        unlink($photo_path);

      if (file_exists($thumbnail_path))
        unlink($thumbnail_path);
    }
    
    // 刪除儲存在資料庫的相片資訊
    $sql = "DELETE FROM photo WHERE album_id = ?
            AND EXISTS(SELECT 1 FROM album WHERE id = ? AND owner = ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$album_id, $album_id, $login_user]);

    // 刪除儲存在資料庫的相簿資訊 	
    $sql = "DELETE FROM album WHERE id = ? AND owner = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$album_id, $login_user]);

  } catch (PDOException $e) {
    die("刪除失敗: " . $e->getMessage());
  }

  header("location:index.php");
?>