<?php
	require_once "utils/email.class.utils.php";
	
	$emailOject = new EnvoyerEmail();			
	$name = "Pacouley";
	$sujet = "Mot de passe oublié";
	$body = "Test d'envoi d'email !!!";
	$emailOject->envoyerMail("pacouley@gmail.com",$name,$sujet,$body);

	echo "Ok envoyer !!!";