<?php
  require_once("db.php");

  //取得電子賀卡的編號及卡片標題
  $id = $_GET["id"];
  $subject = $_GET["subject"];

  //執行 SQL 命令
  $sql = "SELECT * FROM card_message WHERE id = :id AND subject = :subject";
  $statement = $pdo->prepare($sql);
  $statement->execute([
    ':id' => $id,
    ':subject' => $subject,
  ]);
  $row = $statement->fetch();

  //取得賀卡各欄位的值
  if ($row !== false)
  {
    $id = $row['id'];
    $card_id = $row['card_id'];
    $subject = $row['subject'];
    $from_name = $row['from_name'];
    $from_email = $row['from_email'];
    $to_name = $row['to_name'];
    $to_email = $row['to_email'];
    $music = $row['music'];
    $style = $row['style'];
    $size = $row['size'];
    $color = $row['color'];
    $message = $row['message'];
    $date = $row['date'];
  }
  else
  {
    echo "沒有您的卡片或卡片已經刪除...";
    exit();
  }

  //設定回覆電子賀卡的參數
  $parameter = "from_name=" . urlencode($to_name) . "&to_email=" . $from_email;
  $parameter .= "&to_name=" . urlencode($from_name) . "&from_email=" . $to_email;
  $parameter .= "&subject=Re:" . urlencode($subject);
?>
<!doctype html>
<html>
  <head>
    <title>觀看卡片</title>
    <meta charset="utf-8">
    <embed src="music/<?php echo $music ?>" hidden loop="true"></embed>
  </head>
  <body>
    <p align="center"><img src="images/view.jpg"></p>
    <table width="800" align="center" cellpadding="0" cellspacing="0">
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
          <font color="#9900CC"><br>
          寄件日期：<?php echo $date ?><br>
          寄件人：<a href="mailto:<?php echo $from_email ?>"><?php echo $from_name ?></a><br>
          收件人：<a href="mailto:<?php echo $to_email ?>"><?php echo $to_name ?></a></font>
        </td>
        <td bgcolor="#FFC6E2">
          <font color="#0000FF"><br>Dear, <?php echo $to_name ?>：</font>
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
    <p align="center">
    <a href="index0.php?<?php echo $parameter ?>">我也要寄卡片給他（她）</a></p>
  </body>
</html>
