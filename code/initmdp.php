<?php
session_start();
require_once "db/db_connect.php";
require_once 'models/personne.model.php';
require_once "db/personne.php";
require_once "utils/email.utils.php";

$errMsg = '';
if (isset($_POST['motdepasse'])) {
	$email = $_SESSION['email'];
	$mdp = $_POST['motdepasse'];
	$confmotdepasse = $_POST['confmotdepasse'];
	if($mdp != $confmotdepasse){
		$errMsg = "Le mot de passe doit être le même que sa confirmation<br/>";
	}
	
	if (empty($errMsg)) {
		$personne = getPersonneByEmail($email);
		$personne->motdepasse = $mdp;
		$personne->	token_mdp = "1";
		$personne->date_modif_enr = date("Y-m-d H:i:s");
		$personne->code_user_to_update = $_SESSION['email'];

		// Modifier le mot de passe
		enregistrerInfosCompte($personne);
		$_SESSION['token_mdp'] = "1";

		header("Location: index.php");
		exit;
	}
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="utf-8" />
	<title>Nouveau mot de passe</title>
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
            <div class="nav-wrapper #1565c0 blue darken-3">
                <a href="index.php" class="brand-logo">
                    <img src="assets/img/logo_rlg.png" alt="Louis_Guilloux" class="logo_standard" />
                </a>
                <ul id="nav-mobile" class="right hide-on-med-and-down">
                    <li><?php echo ucfirst($_SESSION['prenom']) . ' ' . strtoupper($_SESSION['nom']); ?></li>
                    <li><a href="logout.php">Déconnexion</a></li>
                </ul>
            </div>
        </nav>
		<div class="section">
			<main>
				<center>
					<div class="section"></div>
					<h5 class="indigo-text">Initialiser votre mot de passe</h5>
					<div class="section"></div>
					<div class='row'>
						<div class='col s12' style="color: red; font-weight: bold;">
							<h5><?php echo $errMsg; ?></h5>
						</div>
					</div>
					<div class="container">
						<div class="z-depth-1 grey lighten-4 row" style="display: inline-block; padding: 32px 48px 0px 48px; border: 1px solid #EEE;">
							<form class="col s12" method="post">
								<div class='row'>
									<div class='input-field col s12'>
										<input type='password' name='motdepasse' id='motdepasse' />
										<label for='motdepasse'>mot de passe</label>
									</div>									
								</div>
								<div class='row'>
									<div class='input-field col s12'>
										<input type='password' name='confmotdepasse' id='confmotdepasse' />
										<label for='confmotdepasse'>confirmation du mot de passe</label>
									</div>									
								</div>

								<center>
									<div class='row'>
										<button type='submit' name='btn_login' class='col s12 btn btn-large waves-effect #1565c0 blue darken-3'>
											Initialiser votre mot de passe
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
			<footer class="page-footer #1565c0 blue darken-3">
				<div class="container">
					<div class="row">
						<div class="col l6 s12">
						</div>
						<div class="col l4 offset-l2 s12">
						</div>
					</div>
				</div>
				<div class="footer-copyright">
					<div class="container">
						&copy; <?php echo date('Y'); ?> Tout droits réservé Réseau Louis Guilloux.
					</div>
				</div>
			</footer>
		</div>
	</div>
</body>

</html>