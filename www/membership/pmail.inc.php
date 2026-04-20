<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\OAuth;
use League\OAuth2\Client\Provider\Google;

// Load Composer's autoloader
require 'vendor/autoload.php';

function getmail(){
// Create an instance; passing `true` enables exceptions
$clientID = "你的_CLIENT_ID";
$clientSecret = "你的_CLIENT_SECRET";
$refreshToken = "你的_REFRESH_TOKEN";
$email = "hw.pcchen@gmail.com";

$mail = new PHPMailer(true);
$mail->isSMTP(); // Tell PHPMailer to use SMTP

// Enable SMTP debugging
/**
 * SMTP::DEBUG_OFF -> off (for production use) 執行時要改成這個選項
 * SMTP::DEBUG_CLIENT -> client messages
 * SMTP::DEBUG_SERVER -> client and server messages
 */
  $mail->SMTPDebug = SMTP::DEBUG_OFF;

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
  return $mail;
}
