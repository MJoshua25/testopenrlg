<?php
function getDemandes($isJson)
{
	global $conn;
	$queryDemandes = "SELECT demandes.id as id, structures.libelle as libelle,";
	$queryDemandes .= " structures.ville as ville,";
	$queryDemandes .= " personne.nom as nom, personne.prenom as prenom,";
	$queryDemandes .= " demandes.date_demande as date_demande";
	$queryDemandes .= " FROM demandes, professionnels, personne, structures";
	$queryDemandes .= " where demandes.professionnelfk = professionnels.id";
	$queryDemandes .= " and professionnels.personnefk = personne.id";
	$queryDemandes .= " and professionnels.structurefk = structures.id";
	$queryDemandes .= " order by nom";
	$data = array();
	$resultDemandes = mysqli_query($conn, $queryDemandes);
	while ($row = mysqli_fetch_array($resultDemandes)) {
		$nestedData = array();
		$nestedData["id"] = $row["id"];		
		$nestedData["nomPrenom"] = utf8_encode($row["nom"]." ".$row["prenom"]);
		$nestedData["libelle"] = utf8_encode($row["libelle"]." ".$row["ville"]);		
		$dateDemande = $row["date_demande"];
		if ($isJson) {
			$dateDemande = date("d/m/Y", strtotime($dateDemande));
		}
		$nestedData["dateDemande"] = $dateDemande;
		$data[] = $nestedData;
	}

	return $data;
}

function getDemandesJson(){
	$json_data = array("data" => getDemandes(true));
	return json_encode($json_data, JSON_UNESCAPED_SLASHES);
}

function getDemandesMigrants(){
	global $conn;
	$queryDemandes = "SELECT demandes.id as id, personne.nom as nom, personne.prenom as prenom";	
	$queryDemandes .= " FROM demandes, patients, personne where demandes.patientfk = patients.id";	
	$queryDemandes .= " and patients.personnefk = personne.id order by nom";	
	$data = array();
	$resultDemandes = mysqli_query($conn, $queryDemandes);
	while ($row = mysqli_fetch_array($resultDemandes)) {
		$nestedData = array();
		$nestedData["id"] = $row["id"];		
		$nestedData["nomPrenom"] = utf8_encode($row["nom"]." ".$row["prenom"]);
		$data[] = $nestedData;
	}

	return $data;
}

function getDemandeByCode($code){
	global $conn;
	$queryDemandeByCode = "SELECT demandes.id as id,professionnelfk,date_demande,date_rendez_vous,";
	$queryDemandeByCode .= "heure_rendez_vous,";
	$queryDemandeByCode .= "minutes_rendez_vous,duree,intervention,telephone,domaine,";	
	$queryDemandeByCode .= " infos_complementaires,patientfk,nom, prenom,date_naissance,";
	$queryDemandeByCode .= " code_sexe, pays_origine, langue";
	$queryDemandeByCode .= " FROM demandes, patients,personne  where demandes.id='" . $code . "'";
	$queryDemandeByCode .= " and patients.personnefk = personne.id";
	$queryDemandeByCode .= " and patients.id = demandes.patientfk";

	$result = mysqli_query($conn, $queryDemandeByCode);
	$demande = new Demande();
	while ($row = mysqli_fetch_array($result)) {
		$demande->id  = $row["id"];
		$demande->professionnelfk = $row["professionnelfk"];
		$demande->date_demande = $row["date_demande"];
		$demande->date_rendez_vous = $row["date_rendez_vous"];
		$demande->heure_rendez_vous = $row["heure_rendez_vous"];
		$demande->minutes_rendez_vous = $row["minutes_rendez_vous"];
		$demande->duree = $row["duree"];
		$demande->intervention = $row["intervention"];
		$demande->telephone = $row["telephone"];		
		$demande->domaine = $row["domaine"];
		$demande->infos_complementaires = $row["infos_complementaires"];
		$demande->nom_patient = $row["nom"];
		$demande->prenom_patient = $row["prenom"];
		$demande->date_naissance_patient = $row["date_naissance"];
		$demande->code_sexe_patient = $row["code_sexe"];    
		$demande->pays_origine_patient = $row["pays_origine"];
		$demande->langue_patient = $row["langue"];
		$demande->patientfk = $row["patientfk"];
	}

	return $demande;
}

function getLangueDemandeByCode($code){
	global $conn;
	$queryLangueDemandeByCode = "SELECT demandes.id as id, personne.nom as nom, personne.prenom as prenom,";
	$queryLangueDemandeByCode .= "personne.id as personnefk FROM demandes,langues,patients,";
	$queryLangueDemandeByCode .= "langues_interprete,personne where demandes.id='".$code ."'";
	$queryLangueDemandeByCode .= " and patients.id=demandes.patientfk and langues.code = patients.langue";
	$queryLangueDemandeByCode .= " and langues_interprete.personnefk = personne.id";
	$queryLangueDemandeByCode .= " and langues_interprete.languefk = langues.id";
	
	$liste_interpretes = array();
	$result = mysqli_query($conn, $queryLangueDemandeByCode);
	while ($row = mysqli_fetch_array($result)) {
		$nestedData = array();
		$nestedData["id"] = $row["id"];		
		$nestedData["nom"] = utf8_encode($row["nom"]);
		$nestedData["prenom"] = utf8_encode($row["prenom"]);
		$nestedData["personnefk"] = utf8_encode($row["personnefk"]);
		$liste_interpretes[] = $nestedData;
	}

	return $liste_interpretes;
}

function enregistrerDemande(Demande $demande, $maj = false)
{
	global $conn;
	$response = array();
	
	$idEnr = $demande->id;
	$code_user_to_create = $demande->code_user_to_create;
	$code_user_to_update = $demande->code_user_to_update;
	$date_crea_enr = $demande->date_crea_enr;
	$date_modif_enr = $demande->date_modif_enr;
	$professionnelfk = $demande->professionnelfk;;
	$date_demande = $demande->date_demande;
	$date_rendez_vous = $demande->date_rendez_vous;;
	$heure_rendez_vous = $demande->heure_rendez_vous;
	$minutes_rendez_vous = $demande->minutes_rendez_vous;
	$duree = $demande->duree;
	$intervention = $demande->intervention;
	$telephone = $demande->telephone;	
	$domaine = $demande->domaine;
	$infos_complementaires = $demande->infos_complementaires;
	$nom_patient = $demande->nom_patient;
    $prenom_patient = $demande->prenom_patient;
    $date_naissance_patient = $demande->date_naissance_patient;
    $code_sexe_patient = $demande->code_sexe_patient;    
    $pays_origine_patient = $demande->pays_origine_patient;
    $langue_patient = $demande->langue_patient; 
	$patientfk = $demande->patientfk;
	$personnefk = $demande->personnefk;

	// utf8
	mysqli_set_charset($conn, 'utf8');
	$resultat = false;
	$response = "";
	$mgsEnr = "";

	if ($maj) {
		$msg = "mises à jour";
		// Mise à jour Demande
		$queryEnregistrerDemande = "UPDATE demandes SET code_user_to_update=";
		$queryEnregistrerDemande .= "'" . $code_user_to_update . "',";
		$queryEnregistrerDemande .= "date_modif_enr='" . $date_modif_enr . "',";
		$queryEnregistrerDemande .= "professionnelfk='" . $professionnelfk . "',";
		$queryEnregistrerDemande .= "date_demande='" . $date_demande . "',";
		$queryEnregistrerDemande .= "date_rendez_vous='" . $date_rendez_vous . "',";
		$queryEnregistrerDemande .= "heure_rendez_vous='" . $heure_rendez_vous . "',";
		$queryEnregistrerDemande .= "minutes_rendez_vous='" . $minutes_rendez_vous . "',";
		$queryEnregistrerDemande .= "duree='" . $duree . "',intervention='" . $intervention . "',";		
		$queryEnregistrerDemande .= "telephone='" . $telephone . "',domaine='" . $domaine . "',";		
		$queryEnregistrerDemande .= "infos_complementaires='" . $infos_complementaires . "',";
		$queryEnregistrerDemande .= "patientfk='" . $patientfk . "' WHERE id='" . $idEnr . "'";		
		// Mise à jour de la demande
		$resultat = mysqli_query($conn, $queryEnregistrerDemande);

		// Mise à jour Patient		
		$queryEnregistrerPatient = "UPDATE patients SET langue='".$langue_patient."',";
		$queryEnregistrerPatient .= " pays_origine='".$pays_origine_patient."' WHERE id=".$patientfk."";		
		mysqli_query($conn, $queryEnregistrerPatient);

		// Mise à jour de la personne
		$queryEnregistrerPatient = "UPDATE personne SET nom='".$nom_patient."',";
		$queryEnregistrerPatient .= " prenom='".$prenom_patient."' WHERE id=".$personnefk."";		
		mysqli_query($conn, $queryEnregistrerPatient);
		
	} else {		
		$msg = "enregistrées";
		// Création du patient
		// Personne
		$queryEnregistrerPersonne = "INSERT INTO personne(code_user_to_create,date_crea_enr,";
		$queryEnregistrerPersonne .= "date_naissance,nom,prenom,code_sexe) ";
		$queryEnregistrerPersonne .= "VALUES('".$_SESSION['email']."','".date('Y-m-d h:i:s')."',";
		$queryEnregistrerPersonne .= "'".$date_naissance_patient."','".$nom_patient."',";
		$queryEnregistrerPersonne .= "'".$prenom_patient."', '".$code_sexe_patient."')";		
		$resultatPersonne = mysqli_query($conn, $queryEnregistrerPersonne);		
		if($resultatPersonne){
			$personneFkresult = mysqli_insert_id($conn);			
			// patient
			if($personneFkresult>0){				
				// Création du patient
				$queryEnregistrerPatient = "INSERT INTO patients(code_user_to_create,date_crea_enr,";
				$queryEnregistrerPatient .= "personnefk,langue,pays_origine) ";
				$queryEnregistrerPatient .= "VALUES('".$_SESSION['email']."','".date('Y-m-d h:i:s')."',";
				$queryEnregistrerPatient .= "'".$personneFkresult."','".$langue_patient."',";
				$queryEnregistrerPatient .= "'".$pays_origine_patient."')";				
				$resultatPatient = mysqli_query($conn, $queryEnregistrerPatient);						
				
				if($resultatPatient){
					$patientFkresult = mysqli_insert_id($conn);										
					if($patientFkresult>0){						
						// Création de la demande
						$queryEnregistrerDemande = "INSERT INTO demandes(code_user_to_create,date_crea_enr,";
						$queryEnregistrerDemande .= "professionnelfk,date_demande,date_rendez_vous,heure_rendez_vous,";
						$queryEnregistrerDemande .= "minutes_rendez_vous,duree,intervention,telephone,";
						$queryEnregistrerDemande .= "domaine,infos_complementaires,patientfk)";
						$queryEnregistrerDemande .= " VALUES('" . $code_user_to_create . "','" . $date_crea_enr . "',";
						$queryEnregistrerDemande .= "'" . $professionnelfk . "', '" . $date_demande . "',";
						$queryEnregistrerDemande .= "'" . $date_rendez_vous . "', '" . $heure_rendez_vous . "',";
						$queryEnregistrerDemande .= "'" . $minutes_rendez_vous . "', '" . $duree . "',";
						$queryEnregistrerDemande .= "'" . $intervention . "', '" . $telephone . "',";
						$queryEnregistrerDemande .= "'" . $domaine . "',";
						$queryEnregistrerDemande .= "'" . $infos_complementaires . "','" . $patientFkresult . "')";
						$resultat = mysqli_query($conn, $queryEnregistrerDemande);					
					}					
				}				
			}
		}
	}
		
	if ($resultat) {
		$mgsEnr .= 'Les informations de la demande ont été ' . $msg . ' avec succès.';
	} else {
		$mgsEnr .= 'Echec lors de la mise à jour de la demande.' . mysqli_error($conn);
	}
	$response = $mgsEnr;

	return $response;
}

function removeDemande($id)
{
	global $conn;
	// Supprimer contrat
	$queryContrat = "DELETE FROM demandes WHERE id=" . $id . "";
	mysqli_query($conn, $queryContrat);
}