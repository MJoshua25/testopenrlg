<?php
function getPersonneAuth($email, $motdepasse)
{
	global $conn;
	$query = "SELECT * FROM personne where email='" . $email . "' and";
	$query .= " motdepasse=md5('" . $motdepasse . "') and token_activation='1'";
	$response = array();
	$result = mysqli_query($conn, $query);
	if ($result) {
		while ($row = mysqli_fetch_array($result)) {
			$response[] = $row;
		}
	}

	return $response;
}

function getPersonneEmail($email)
{
	global $conn;
	$query = "SELECT * FROM personne where email='" . $email . "'";
	$response = array();
	$result = mysqli_query($conn, $query);
	while ($row = mysqli_fetch_array($result)) {
		$response[] = $row;
	}

	return $response;
}

function getPersonneByEmail($email)
{
	global $conn;
	$query = "SELECT * FROM personne where email='" . $email . "'";
	$result = mysqli_query($conn, $query);

	$personne = new Personne();
	while ($row = mysqli_fetch_array($result)) {
		$personne->id = $row["id"];
		$personne->email = $row["email"];
		$personne->nom = $row["nom"];
		$personne->prenom = $row["prenom"];
		$personne->date_modif_enr = $row["date_modif_enr"];
		$personne->code_user_to_update = $row["code_user_to_update"];
		$personne->code_civilite = $row["code_civilite"];
		$personne->code_sexe = $row["code_sexe"];
		$personne->token_activation = $row["token_activation"];
    	$personne->token_mdp = $row["token_mdp"];
	}
	return $personne;
}

function getPersonneByInfos(
	$id,
	$email,
	$nom,
	$prenom,
	$date_modif_enr,
	$code_user_to_update,
	$code_civilite,
	$code_sexe
) {
	$personne = new Personne();
	$personne->id = $id;
	$personne->email = $email;
	$personne->nom = $nom;
	$personne->prenom = $prenom;
	$personne->date_modif_enr = $date_modif_enr;
	$personne->code_user_to_update = $code_user_to_update;
	$personne->code_civilite = $code_civilite;
	$personne->code_sexe = $code_sexe;
	return $personne;
}

function isPersonneConnecte($email, $motdepasse)
{
	$isConnect = false;
	if (!empty(getPersonneAuth($email, $motdepasse))) {
		$isConnect = true;
	}
	return $isConnect;
}

function enregistrerInfosCompte(Personne $personne)
{
	global $conn;
	$id = $personne->id;
	$email = $personne->email;
	$nom = $personne->nom;
	$prenom = $personne->prenom;
	$date_modif_enr = $personne->date_modif_enr;
	$code_user_to_update = $personne->code_user_to_update;
	$code_civilite = $personne->code_civilite;
	$code_sexe = $personne->code_sexe;
	$motdepasse = md5($personne->motdepasse);
	$token_activation = $personne->token_activation;
	$token_mdp = $personne->token_mdp;

	$query = "UPDATE personne SET nom='" . $nom . "', prenom='" . $prenom . "',code_sexe='" . $code_sexe . "',";
	$query .= "date_modif_enr='" . $date_modif_enr . "',code_user_to_update='" . $code_user_to_update . "',";
	$query .= "code_civilite='" . $code_civilite . "',motdepasse='" . $motdepasse . "',";
	$query .= "token_activation='" . $token_activation . "',token_mdp='" . $token_mdp . "'";
	$query .= " WHERE email='" . $email . "'";
	
	// utf8
	mysqli_set_charset($conn,'utf8');
	$response = array();
	if (mysqli_query($conn, $query)) {
		$response[0] = 'Informations du compte utilisateur mis à jour avec succès.';
	} else {
		$response[0] = 'Echec lors de la mise à jour du compte utilisateur.' . mysqli_error($conn);
	}
	$response[] = $id;

	return $response;
}
