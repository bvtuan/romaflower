<?php

function sendmail($addressmail,$title,$content){
	
require_once('mail/class.phpmailer.php');
//require_once("mail/class.smtp.php"); 
$fromtitle="Tink31 Forum";
$mail             = new PHPMailer();

$body=$content;

$mail->IsSMTP(); // telling the class to use SMTP
$mail->Host       = "smtp@gmail.com"; // SMTP server
$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
                                           // 1 = errors and messages
                                           // 2 = messages only
$mail->SMTPAuth   = true;                  // enable SMTP authentication
$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
$mail->Port       = 465;                   // set the SMTP port for the GMAIL server
$mail->Username   = "admin@bvtuan.vnn.ms";  // GMAIL username
$mail->Password   = "detal9icon7";            // GMAIL password

$mail->SetFrom('bachvtuan@gmail.com',$fromtitle);

$mail->AddReplyTo('bachvtuan@gmail.com',$fromtitle);

$mail->Subject    = $title;

$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

$mail->MsgHTML($body);

$mail->AddAddress($addressmail,"Chao ban");

if(!$mail->Send()) {
  die ("Mailer Error: " . $mail->ErrorInfo);
} else {
  echo "Message sent!";
}
}
 
?>
