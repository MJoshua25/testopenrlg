<?php
session_start();
require_once "db/db_connect.php";
require_once 'models/personne.model.php';
require_once "db/personne.php";

$errMsg = '';
if (isset($_POST['username'])) {
	$email = $_POST['username'];
	$motdepasse  = $_POST['password'];
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$errMsg = "L'adresse email n'est pas valide.";
		$_SESSION['isLogin'] = 'false';
	} else {
		$isConnect = isPersonneConnecte($email, $motdepasse);
		if ($isConnect) {
			$personne = getPersonneEmail($email);
			$_SESSION['isLogin'] = "isOk";
			$_SESSION['email'] = $personne[0]["email"];
			$_SESSION['nom'] = $personne[0]["nom"];
			$_SESSION['prenom'] = $personne[0]["prenom"];
			$_SESSION['role'] = $personne[0]["role"];
			$_SESSION['token_mdp'] = $personne[0]["token_mdp"];
			
			header("Location: index.php");
			exit;
		} else {
			$_SESSION['isLogin'] = 'false';
			$errMsg = 'Login ou mot de passe incorrect</b></span>';
		}
	}
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8" />
	<title>Application RLG - Connexion</title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	<!--<link rel="stylesheet" href="assets/css/bootstrap/css/bootstrap.min.css"> -->
	<link rel="stylesheet" href="assets/css/materialize.min.css">
	<link rel="stylesheet" href="assets/css/main.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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
					<div class="section">
						<img src="assets/img/logo_rlg.png" alt="Louis_Guilloux" class="logo_standard" />
					</div>
					<h5 class="indigo-text">Application RLG - Connexion</h5>
					<div class="section"></div>
					<div class="container">
						<div class="z-depth-1 grey lighten-4 row" style="display: inline-block; padding: 32px 48px 0px 48px; border: 1px solid #EEE;">

							<form class="col s12" action="login.php" method="post">
								<div class='row'>
									<div class='col s12' style="color: red; font-weight: bold;">
										<h5><?php echo $errMsg; ?></h5>
									</div>
								</div>
								<div class='row'>
									<div class='input-field col s12'>
										<i class="material-icons prefix">email</i>
										<input class='validate' type='text' name='username' id='username' />
										<label for='username'>Saisir votre adresse email</label>
									</div>
								</div>
								<div class='row'>
									<div class='input-field col s12'>
										<i class="material-icons prefix">security</i>
										<input class='validate' type='password' name='password' id='password' />
										<label for='password'>Saisir votre mot de passe</label>
									</div>
									<label style='float: right;'>										
										<a class='pink-text' href='forgetmdp.php'>
											<b>Mot de passe oublié?</b>
										</a>
									</label>
								</div>

								<br />
								<center>
									<div class='row'>
										<button type='submit' name='btn_login' class='col s12 btn btn-large waves-effect #1565c0 blue darken-3'>Se connecter</button>
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