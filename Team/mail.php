<?php
require 'PHPMailer/PHPMailerAutoload.php';

$name=$_GET['name'];
$email=$_GET['email'];
$tripname=$_GET['tripname'];
#$trip=$_GET['trip'].'?name='.$tripname;
$trip=$_GET['trip'];
$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'uberlyfttripplanner@gmail.com';                 // SMTP username
$mail->Password = 'cmpe273sithuaung';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to

$mail->setFrom('uberlyfttripplanner@gmail.com', 'Mailer');

$mail->addAddress($email, $name); 

//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML
$temp='Hi '.$name .' , <p> This is Coders United. <p> You searched for a trip on our website. Please click <a href="'.$trip.'">here</a> for more details.<p> Happy Holidays,<p> Coders United Team';
$mail->Subject = 'Trip Planning by Code Gladiators';
$mail->Body    = $temp;
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
    echo " <a href=\"javascript:history.go(-1)\">GO BACK</a>";

}