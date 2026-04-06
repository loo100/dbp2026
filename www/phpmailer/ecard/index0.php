<?php
  $from_name = "";
  $from_email = "";
  $to_name = "";
  $to_email = "";
  $subject = "";
	
  if (isset($_GET["from_name"]))
  {
    $from_name = $_GET["from_name"];
    $from_email = $_GET["from_email"];
    $to_name = $_GET["to_name"];
    $to_email = $_GET["to_email"];
    $subject = $_GET["subject"];
  }
?>
<!doctype html>
<html>
  <head>
    <title>電子賀卡 DIY</title>
    <meta charset="utf-8">
    <script type="text/javascript">
      function check_data()
      {
        if (document.eCard.subject.value.length == 0)
          alert("卡片通知標題欄位不可以空白哦！");
        else if (document.eCard.from_name.value.length == 0)
          alert("寄件人姓名欄位不可以空白哦！");
        else if (document.eCard.from_email.value.length == 0)
          alert("寄件人電子郵件欄位不可以空白哦！");
        else if (document.eCard.to_name.value.length == 0)
          alert("收件人姓名欄位不可以空白哦！");
        else if (document.eCard.to_email.value.length == 0)
          alert("收件人電子郵件欄位不可以空白哦！");
        else if (document.eCard.message.value.length == 0)
          alert("卡片內容欄位不可以空白哦！");		
        else
          eCard.submit();
      }
    </script>
  </head>		
  <body>
    <p align="center"><img src="images/title.jpg"></p>
    <form name="eCard" method="post" action="preview.php" >
      <p><img src="images/步驟一.jpg"></p>
      <table align="center" width="750">
        <?php
          $card_id = 0;
					
          for ($i = 1; $i <= 2; $i++)
          {
            for ($j = 1; $j <= 4; $j++)
            {
              $card_id += 1;
              echo "<td>";
              echo "<input type='radio' name='card_id' value='"; 
              echo $card_id .".jpg' checked>";
              echo "<a href='images/" . $card_id . ".jpg' target='_blank'>";
              echo "<img src='images/" . $card_id . "s.jpg' border='1'></a>";
              echo "</td>";
            }
            echo "</tr>";
          }
        ?>
      </table>
      <p><img src="images/步驟二.jpg"></p>
      <table width="750" align="center" cellspacing="0" cellpadding="4">
        <tr bgcolor="#F36B9D"> 
          <td colspan="2">1.卡片通知標題：
            <input name="subject" size="50" value="<?php echo $subject ?>"></td>
        </tr>
        <tr bgcolor="#FEA1C1"> 
          <td>2. 寄信人姓名：
            <input name="from_name" size="10" value="<?php echo $from_name ?>"></td>
          <td>電子郵件信箱：
            <input name="from_email" size="30" value="<?php echo $from_email ?>"></td>
        </tr>
        <tr bgcolor="#F36B9D"> 
          <td>3. 收信人姓名：
            <input name="to_name" size="10" value="<?php echo $to_name ?>"></td>
          <td>電子郵件信箱：
            <input name="to_email" size="30" value="<?php echo $to_email ?>"></td>
        </tr>
        <tr bgcolor="#FEA1C1"> 
          <td colspan="2">4. 選擇音樂： 
            <select name="music">
              <option value="music_01.mid" selected>如果雲知道</option>
              <option value="music_02.mid">往事隨風</option>
              <option value="music_03.mid">流浪的小孩</option>
              <option value="music_04.mid">棋子</option>
            </select>
          </td>
        </tr>
        <tr bgcolor="#F36B9D"> 
          <td colspan="2">5. 選擇卡片字體 ： 
            <select name="style">
              <option value="normal" selected>一般</option>
              <option value="italic">斜體</option>
            </select>
          　大小： 
            <select name="size">
              <option value="8 pt">8 pt</option>
              <option value="10 pt">10 pt</option>
              <option value="12 pt" selected>12 pt</option>
              <option value="14 pt">14 pt</option>
              <option value="16 pt">16 pt</option>
              <option value="20 pt">20 pt</option>
              <option value="24 pt">24 pt</option>
            </select>
          　顏色： 
            <select name="color">
              <option value="#000000" selected>黑色</option>
              <option value="#FF0000">紅色</option>
              <option value="#FF6633">橙色</option>
              <option value="#339900">綠色</option>
              <option value="#0099FF">藍色</option>
              <option value="#9933FF">紫色</option>
              <option value="#BB0000">暗紅色</option>
              <option value="#005500">深綠色</option>
              <option value="#333399">深藍色</option>
              <option value="#663399">深紫色</option>
              <option value="#770000">咖啡色</option>
            </select>
          </td>
        </tr>
        <tr bgcolor="#FEA1C1"> 
          <td colspan="2">6.卡片內容：<br>&nbsp;&nbsp;&nbsp;&nbsp;
            <textarea cols="72" name="message" rows="8"></textarea>
          </td>
        </tr>
      </table><br>
      <p align="center">
        <input type="button" value="卡片預覽" onClick="check_data()"> 
        <input type="reset" value="重新填寫">
      </p>
    </form>
  </body>
</html>