<!DOCTYPE html>
<html>
  <head>
  	<title>電子相簿</title>
    <meta charset="utf-8">
    <script type="text/javascript">
      function DeletePhoto(album_id, photo_id)
      {
        if (confirm("請確認是否刪除此相片？"))
          location.href = "delPhoto.php?album_id=" + album_id + "&photo_id=" + photo_id;
      }
    </script>
  </head>	
  <body>
    <p align="center"><img src="Title.png"></p>
    <?php 
      require_once("db_config.php");
      $album_id = $_GET["album_id"]; 
      
      // 取得登入者的帳號
	    $login_user = "";
	    session_start();
	    if (isset($_SESSION["login_user"]))
        $login_user = $_SESSION["login_user"];

      try {
        // 取得相簿的名稱及相簿的主人
        $sql = "SELECT name, owner FROM album WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$album_id]);
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        $album_name = $row->name;
        $album_owner = $row->owner;
        
        echo "<p align='center'>$album_name</p>";
										
        // 取得相簿裡所有照片的縮圖
        $sql = "SELECT id, name, filename FROM photo WHERE album_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$album_id]);
        $photos = $stmt->fetchAll();
	      $total_photo = count($photos);
	  
      echo "<table border='0' align='center'>";

      // 指定每列顯示幾張照片
      $photo_per_row = 5;
      					
      // 顯示相片縮圖
      $i = 1;
      foreach ($photos as $row)
      {
      	$photo_id = $row["id"];
      	$photo_name = $row["name"];
      	$file_name = $row["filename"];
      	
        if ($i % $photo_per_row == 1)
          echo "<tr align='center'>";
        
        echo "<td width='160px'><a href='photoDetail.php?album=$album_id&photo=$photo_id'>
              <img src='Thumbnail/$file_name' style='border-color:Black;border-width:1px'>
              <br>$photo_name</a>";
        
        if ($album_owner == $login_user)
          echo "<br><a href='editPhoto.php?photo_id=$photo_id'>編輯</a> 
               <a href='#' onclick='DeletePhoto($album_id, $photo_id)'>刪除</a>";
          
        echo "<p></td>";
        
        if ($i % $photo_per_row == 0 || $i == $total_photo)
          echo "</tr>";
        
        $i++;
      }
      
      echo "</table>" ;
      
      } catch (PDOException $e) {
        die("查詢失敗: " . $e->getMessage());
      }
      
      echo "<hr><p align='center'>";
      if ($album_owner == $login_user)
        echo "<a href='uploadPhoto.php?album_id=$album_id'>上傳相片</a> ";
    ?>
    <a href='index.php'>回首頁</a></p>
  </body>                                                                                 
</html>