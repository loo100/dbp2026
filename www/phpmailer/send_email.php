<?php
$clientId = '你的_CLIENT_ID';
$clientSecret = '你的_CLIENT_SECRET';
$refreshToken = '你的_REFRESH_TOKEN';
// prepare the mail contents
$email = 'hw.pcchen@gmail.com';
// $email = 'pcchen002@gmail.com';
$receiver_email = 'pcchen001@gmail.com'; // Email-address of the recipient of the email
$subject = '=?utf-8?B?'.base64_encode('中文主旨 subject for php mailer').'?=';
$body = '中文內容<br>a html body here.<br> hw.pcchen send<br>';

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\OAuth;
use League\OAuth2\Client\Provider\Google;

// Load Composer's autoloader
require 'vendor/autoload.php';

// Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try{
  $mail->isSMTP(); // Tell PHPMailer to use SMTP

// Enable SMTP debugging
/**
 * SMTP::DEBUG_OFF -> off (for production use) 執行時要改成這個選項
 * SMTP::DEBUG_CLIENT -> client messages
 * SMTP::DEBUG_SERVER -> client and server messages
 */
  $mail->SMTPDebug = SMTP::DEBUG_SERVER;

  // Set the hostname of the mail server
  $mail->Host = 'smtp.gmail.com';
  
  // Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
  $mail->Port = 587;

  // Set the encryption mechanism to use - STARTTLS or SMTPS
  $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

  // Whether to use SMTP authentication
  $mail->SMTPAuth = true; 
  
  // Set AuthType to use XOAUTH2
  $mail->AuthType = 'XOAUTH2';

  // Create a new OAuth2 provider instance
  $provider = new Google(
    [
        "clientId" => $clientID,
        "clientSecret" => $clientSecret,
    ]
  );

  // Pass the OAuth provider instance to PHPMailer
  $mail->setOAuth(
    new OAuth(
        [
            "provider" => $provider,
            "clientId" => $clientID,
            "clientSecret" => $clientSecret,
            "refreshToken" => $refreshToken,
            "userName" => $email,
        ]
    )
  );

	  /*
	  * Set who the message is to be sent from
	  * For gmail, this generally needs to be the same as the user you logged in as
	  */

	  $mail->setFrom($email, 'pcchenathw');
	  
	  $mail->addAddress($receiver_email);
	  /* if you want to send email to multiple users, then add the email addresses you which you want to send. e.g -
	  * $mail->addAddress('reciver2@gmail.com');
	  * $mail->addAddress('reciver3@gmail.com');
	  */
	
	  $mail->isHTML(true); # Set email format to HTML
	  $mail->Subject = $subject;
	  $mail->Body    = $body;
	  $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
	  $mail->addAttachment('./att.txt');
	  /*
  * For Attachments -
	  * $mail->addAttachment('/var/tmp/file.tar.gz'); Add attachments
	  * $mail->addAttachment('/tmp/image.jpg', 'new.jpg'); You can specify the file name in the second parameter
	  */
	  // Call the send() method to send the mail.
	  $mail->send();
	  echo 'Message has been sent 郵件已送出';
	}
	catch(Exception $e){
	  echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
