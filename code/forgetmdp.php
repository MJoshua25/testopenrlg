<?php
require_once "db/db_connect.php";
require_once 'models/personne.model.php';
require_once "db/personne.php";

$errMsg = '';
if (isset($_POST['email'])) {
	$email = $_POST['email'];
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$errMsg = "L'adresse email n'est pas valide.";
	}

	if (empty($errMsg)) {
		$personne = getPersonneByEmail($email);		
		// Vérifions que la personne n'est pas
		if (!empty($personne)) {
			/*$emailOject = new EnvoyerEmail();	
			$name = $personne->nom ." ".$personne->prenom;
			$motpasse = "openrlg2019";
			$sujet = "Mot de passe oublié";
			$body = "Vous avez demandé votre mot de passe.<br/>";
			$body .= "  Voici votre nouveau mot de passe : ".$motpasse."";
			$personne->motdepasse = $motpasse;
			$personne->token_activation = 1;
			$personne->token_mdp = 0;
			enregistrerInfosCompte($personne);
			$emailOject->envoyerMail($email,$name,$sujet,$body);*/
			$errMsg = "Un email vous a été envoyé à cette adresse " . $email . ".<br/>";
			$errMsg .= " N'oublier pas de vérifier aussi dans le dossier Spams.";			
		} else {
			$errMsg = "Nous n’avons pas trouvé de compte correspondant à ".$email."<br/>";
			$errMsg .= " Contacter le réseau Louis Guilloux.";
		}
	}
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="utf-8" />
	<title>Mot de passe oublié</title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	<link rel="stylesheet" href="assets/css/materialize.min.css">
	<script language="JavaScript" type="text/javascript" src="assets/js/dataTables/media/js/jquery.js"></script>
	<script language="JavaScript" type="text/javascript" src="assets/js/materialize.min.js"></script>
</head>

<body>
	<div>
		<nav>
			<div class="nav-wrapper #1565c0 blue darken-3"></div>
		</nav>
		<div class="section">
			<main>
				<center>
					<div class="section"></div>
					<h5 class="indigo-text">Mot de passe oublé</h5>
					<div class="section"></div>
					<div class='row'>
						<div class='col s12' style="color: red; font-weight: bold;">
							<h5><?php echo $errMsg; ?></h5>
						</div>
					</div>
					<div class="container">
						<div class="z-depth-1 grey lighten-4 row" style="display: inline-block; padding: 32px 48px 0px 48px; border: 1px solid #EEE;">
							<form class="col s12" action="forgetmdp.php" method="post">
								<div class='row'>
									<div class='input-field col s12'>
										<input type='text' name='email' id='email' />
										<label for='email'>Saisir votre adresse</label>
									</div>
									<label style='float: right;'>
										<a class='pink-text' href='login.php'><b>Retour à la connexion</b></a>
									</label>
								</div>

								<br />
								<center>
									<div class='row'>
										<button type='submit' name='btn_login' class='col s12 btn btn-large waves-effect #1565c0 blue darken-3'>
											Demander votre mot de passe
										</button>
									</div>
								</center>
							</form>
						</div>
					</div>
				</center>
				<div class="section"></div>
				<div class="section"></div>
			</main>			
		</div>
	</div>
</body>

</html>