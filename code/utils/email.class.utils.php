<?php

	use PHPMailer\PHPMailer\PHPMailer;

	require 'assets/PHPMailer/src/Exception.php';
	require 'assets/PHPMailer/src/PHPMailer.php';
	require 'assets/PHPMailer/src/SMTP.php';

	class EnvoyerEmail
	{			
		public function envoyerMail($email,$name,$sujet,$body){

			$msg = "";

			$mail = new PHPMailer(true);
			//Server settings	
			$mail->IsSMTP();
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = "ssl";
			$mail->Host = "smtp.gmail.com";
			$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
			$mail->Port       = 587;
			$mail->Username = "pacouley@gmail.com";
			$mail->Password = "#pa79%co";						
			$mail->AddAddress($email, $name);
			$mail->SetFrom("o.vats@rlg35.org", "Réseau Louis Guilloux");
			$mail->Subject = $sujet;
			$mail->Body = $body;

			try{
				$mail->Send();
				$msg = "Success!";
			} catch(Exception $e){
				//Something went bad
				$msg = "Fail - " . $mail->ErrorInfo;
			}
			
			return $msg;
		}
	}
?>