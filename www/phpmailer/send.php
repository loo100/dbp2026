<?php
	require 'pmail.inc.php';

	$email = 'hw.pcchen@gmail.com';     // Email-address of the sender (your gmail)
    $receiver_email = 'pcchen@gm.nuu.edu.tw'; // Email-address of the recipient of the email
	try{
      $mail = getmail();
	  $mail->setFrom($email, 'pcchen_at_hw');
	
	  $mail->addAddress($receiver_email);
	  /* if you want to send email to multiple users, then add the email addresses you which you want to send. e.g -
	  * $mail->addAddress('reciver2@gmail.com');
	  * $mail->addAddress('reciver3@gmail.com');
	  */
	
	  $mail->isHTML(true); # Set email format to HTML
	  $mail->Subject = "Subject Of the email";
	  $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
	  $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
	
	  /*
  	  * For Attachments -
	  * $mail->addAttachment('/var/tmp/file.tar.gz'); Add attachments
	  * $mail->addAttachment('/tmp/image.jpg', 'new.jpg'); You can specify the file name in the second parameter
	  */
	  // Call the send() method to send the mail.
	  $mail->send();
	  echo 'Message has been sent 郵件已送出';
	}
	catch (e) {
	echo 'error!';
	}