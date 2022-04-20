<?php
error_reporting(0);
//include('../../../config/koneksi.php'); 
//EMAIL NOTIFIKASI
date_default_timezone_set('Etc/UTC');
/*autoload phpmailer*/
require 'PHPMailer/PHPMailerAutoload.php';
//Create a new PHPMailer instance

$t = mysqli_fetch_array(mysqli_query($conn, "select *from user where username='$_POST[assign_group]'"));

$mail = new PHPMailer;

//Tell PHPMailer to use SMTP
$mail->isSMTP();

$mail->SMTPDebug = 0;

//Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';

//Set the hostname of the mail server
$mail->Host = 'smtp.gmail.com';
// use
// $mail->Host = gethostbyname('smtp.gmail.com');
// if your network does not support SMTP over IPv6

//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
$mail->Port = 587;

//Set the encryption system to use - ssl (deprecated) or tls
$mail->SMTPSecure = 'tls';

//Whether to use SMTP authentication
$mail->SMTPAuth = true;

//Username to use for SMTP authentication - use full email address for gmail
$mail->Username = "krisanthium.op@gmail.com";

//Password to use for SMTP authentication
$mail->Password = "KOP192315";

//Set who the message is to be sent from
$mail->setFrom('krisanthium.op@gmail.com', 'e-task@krisanthium.com');

//Set an alternative reply-to address
$mail->addReplyTo('krisanthium.op@gmail.com', 'e-task@krisanthium.com');

//Set who the message is to be sent to
$mail->addAddress("$t[email]", "$t[fullname]");

//Set the subject line
$mail->Subject = "PERHATIAN! Pemberian Tugas, kode : $_POST[idprob]";
$mail->Body    = "Yth. Bapak/Ibu <strong> $t[fullname]</strong><br><br>Berikut ini Kami Tugaskan Bapak/Ibu untuk melakukan pekerjaan berikut :<br><br>
					Kode Tugas : $_POST[idprob]<br>
					Link : <a href='http://vpn.krisanthium.com/etask/p/page.php?p=todolist&act=problem-detail&id=$_POST[idprob]&i=as'>KLIK UNTUK TUGAS SAYA</a>";
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body

//Replace the plain text body with one created manually
$mail->AltBody = 'This is a plain-text message body';


//send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent !";
}
?>