<?php
  //取得表單資料
  $card_id = $_POST["card_id"];
  $subject = $_POST["subject"];
  $from_name = $_POST["from_name"];
  $from_email = $_POST["from_email"]; 
  $to_name = $_POST["to_name"]; 
  $to_email = $_POST["to_email"]; 
  $music = $_POST["music"]; 
  $style = $_POST["style"];
  $size = $_POST["size"];
  $color = $_POST["color"];
  $message = $_POST["message"];
?>
<!doctype html>
<html>
  <head>
    <title>卡片預覽</title>
    <meta charset="utf-8">
    <embed src="music/<?php echo $music ?>" hidden loop="true"></embed>
  </head>
  <body>
    <p align="center"><img src="images/preview.jpg"></p>
    <table width="800" align="center" cellpadding="0" cellspacing="0" border="0">
      <tr> 
        <td colspan="2" bgcolor="#FFFFCC"> 
          <p align="center"><br><img src="images/<?php echo $card_id ?>"><br><br></p></td>
      </tr>
      <tr> 
        <td colspan="2" height="22" bgcolor="#CCCCFF" valign="middle"> 
          <p align="center"><font color="#9900CC">標題：<?php echo $subject ?></font></p>
        </td>
      </tr>
      <tr> 
        <td width="28%" bgcolor="#FFC6E2" valign="top"> 
          <br><font color="#9900CC">
          寄件日期：<?php echo date("Y-m-d H:i:s") ?><br>
          寄件人：<a href="MAILTO:<?php echo $from_email ?>"><?php echo $from_name ?></a><br>
          收件人：<a href="MAILTO:<?php echo $to_email ?>"><?php echo $to_name ?></a></font>
        </td>
        <td bgcolor="#FFC6E2">
          <br><font color="#0000FF">Dear, <?php echo $to_name ?>：</font>
          <p style="font-style:<?php echo $style ?>; color:<?php echo $color ?>;
            font-size:<?php echo $size ?>; padding-left:3mm; padding-right:3mm">
            <?php echo $message ?>
          </p>
          <div align="right">
            <font color="#0000FF">Write By <?php echo $from_name ?></font>
          </div>
        </td>
      </tr>
    </table>
    <form action="ecard.php" method="post" >
      <input type="hidden" name="card_id" value="<?php echo $card_id ?>">
      <input type="hidden" name="subject" value="<?php echo $subject ?>">
      <input type="hidden" name="from_name" value="<?php echo $from_name ?>">
      <input type="hidden" name="from_email" value="<?php echo $from_email ?>">
      <input type="hidden" name="to_name" value="<?php echo $to_name ?>">
      <input type="hidden" name="to_email" value="<?php echo $to_email ?>">
      <input type="hidden" name="music" value="<?php echo $music ?>">
      <input type="hidden" name="style" value="<?php echo $style ?>">
      <input type="hidden" name="size" value="<?php echo $size ?>">
      <input type="hidden" name="color" value="<?php echo $color ?>">
      <input type="hidden" name="message" value="<?php echo $message ?>">
      <p align="center">
        <a href="javascript:history.back()"><img src="images/modify.gif" border="0"></a> 　　 
        <input type="image" src="images/sent.gif">
      </p>
    </form>
  </body>
</html>