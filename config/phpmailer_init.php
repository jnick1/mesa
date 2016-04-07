<?php
require_once $homedir."vendor/phpmailer/phpmailer/PHPMailerAutoload.php";

$mail = new PHPMailer;
$mailfail = false;

$mail->Timeout = 10;

$mail->isSMTP();                                // Set mailer to use SMTP
$mail->CharSet="UTF-8";
$mail->Host = "smtp.gmail.com";                 // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                         // Enable SMTP authentication
$mail->Username = "mesaorganizer@gmail.com";    // SMTP username
$mail->Password = "wicora thicsh";              // SMTP password
$mail->SMTPSecure = "ssl";                      // Enable TLS encryption, `ssl` also accepted
$mail->Port = 465;                              // TCP port to connect to

$mail->setFrom("mesaorganizer@gmail.com", "Mesa Organizer");
$mail->addReplyTo("mesaorganizer@gmail.com", "Mesa Organizer");
$mail->isHTML(true);                            // Set email format to HTML

?>
