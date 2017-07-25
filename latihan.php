	
	<?php
	require("smtp/phpmailer.php");
						
						
$mail = new PHPMailer; 
$mail->IsSMTP();
$mail->SMTPSecure = 'ssl'; 
$mail->Host = "mail.jasapembuatanwebsite.co.id"; //host masing2 provider email
$mail->SMTPDebug = 2;
$mail->Port = 465;
$mail->SMTPAuth = true;
$mail->Username = "info@jasapembuatanwebsite.co.id"; //user email
$mail->Password = "Smart1234"; //password email 
$mail->SetFrom("info@jasapembuatanwebsite.co.id"); //set email pengirim
$mail->Subject = "halohalobandung"; //subyek email
$mail->AddAddress("amaragya@gmail.com");  //tujuan email
$mail->MsgHTML("jaisfjas");
if(!$mail->send()){
 echo "Mailer Error: " . $mail->ErrorInfo;
}						       