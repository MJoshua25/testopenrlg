<?php
function getInterventions($typeEtat, $isJson)
{
	global $conn;
	$queryInterventions = "SELECT interventions.id as id, interventions.etat as etat,";
	$queryInterventions .= " personne.nom as nom, personne.prenom as prenom,";
	$queryInterventions .= " demandes.date_rendez_vous as date_rendez_vous";
	$queryInterventions .= " FROM interventions, interpretes, personne, demandes";
	$queryInterventions .= " where interventions.interpretefk = interpretes.personnefk";
	$queryInterventions .= " and interpretes.personnefk = personne.id";
	$queryInterventions .= " and interventions.demandefk = demandes.id";

	$data = array();

	// utf8
	mysqli_set_charset($conn, 'utf8');
	$resultInterventions = mysqli_query($conn, $queryInterventions);
	while ($row = mysqli_fetch_array($resultInterventions)) {
		$nestedData = array();
		$nestedData["id"] = $row["id"];
		$nestedData["nomPrenom"] = utf8_encode($row["nom"] . " " . $row["prenom"]);
		$dateRendezVous = $row["date_rendez_vous"];
		if ($isJson) {
			$dateRendezVous = date("d/m/Y", strtotime($dateRendezVous));
		}
		$nestedData["dateRendezVous"] = $dateRendezVous;
		$nestedData["etat"] = $typeEtat[$row["etat"]];
		$data[] = $nestedData;
	}

	return $data;
}

function getInterventionsJson($typeEtat)
{
	$json_data = array("data" => getInterventions($typeEtat, true));
	return json_encode($json_data, JSON_UNESCAPED_SLASHES);
}

function getInterventionsEventByCode($code)
{
	global $conn;
	$queryInterventions = "SELECT interventions.id as id, interventions.etat as etat,";
	$queryInterventions .= " personne.nom as nom, personne.prenom as prenom,";
	$queryInterventions .= " demandes.date_rendez_vous as date_rendez_vous,";
	$queryInterventions .= " demandes.heure_rendez_vous as heure_rendez_vous,";
	$queryInterventions .= " demandes.minutes_rendez_vous as minutes_rendez_vous,";
	$queryInterventions .= " demandes.duree as duree FROM interventions, interpretes,personne,";	
	$queryInterventions .= " demandes where interventions.interpretefk = interpretes.personnefk";
	$queryInterventions .= " and interpretes.personnefk = personne.id";
	$queryInterventions .= " and interventions.demandefk = demandes.id";
	$queryInterventions .= " and interpretes.personnefk = ".$code."";
	$data = array();

	// utf8
	mysqli_set_charset($conn, 'utf8');
	$resultInterventions = mysqli_query($conn, $queryInterventions);
	while ($row = mysqli_fetch_array($resultInterventions)) {
		$nestedData = array();		
		$nestedData["title"] = utf8_encode($row["nom"] . " " . $row["prenom"]);		
		$dateDebut = date("Y-m-d", strtotime($row["date_rendez_vous"]));		
		$nestedData["start"] = $dateDebut."T".$row["heure_rendez_vous"].":".$row["minutes_rendez_vous"].":00";
		$heureFin = $row["heure_rendez_vous"];
		$minuteFin = $row["minutes_rendez_vous"] + $row["duree"];
		$dateFin = date("Y-m-d", strtotime($row["date_rendez_vous"]));
		if($minuteFin>=60){
			$minuteFin = $minuteFin - 60;
			$heureFin = $heureFin + 1;
			if($heureFin>=24){
				$heureFin = $heureFin - 24;
				$dateFin = date("Y-m-d", strtotime($row["date_rendez_vous"]. "+1 days"));		
			}
		}
		$nestedData["end"] = $dateFin."T".$heureFin.":".$minuteFin.":00";
		$data[] = $nestedData;
	}

	return $data;
}

function getInterventionByCode($code)
{
	global $conn;
	$queryInterventionByCode = "SELECT * FROM interventions  where id='" . $code . "'";

	$result = mysqli_query($conn, $queryInterventionByCode);
	$intervention = new Intervention();
	while ($row = mysqli_fetch_array($result)) {
		$intervention->id  = $row["id"];
		$intervention->lieurdvfk = $row["lieurdvfk"];
		$intervention->interpretefk = $row["interpretefk"];
		$intervention->demandefk = $row["demandefk"];
		$intervention->heure_arrivee = $row["heure_arrivee"];
		$intervention->minutes_arrivee = $row["minutes_arrivee"];
		$intervention->heure_depart = $row["heure_depart"];
		$intervention->minutes_depart = $row["minutes_depart"];
		$intervention->duree = $row["duree"];
		$intervention->indisponibilite = $row["indisponibilite"];
		$intervention->signature = $row["signature"];
		$intervention->etat = $row["etat"];
	}

	return $intervention;
}

function enregistrerIntervention(Intervention $intervention, $maj = false)
{
	global $conn;
	$response = array();

	$idEnr = $intervention->id;
	$code_user_to_create = $intervention->code_user_to_create;
	$code_user_to_update = $intervention->code_user_to_update;
	$date_crea_enr = $intervention->date_crea_enr;
	$date_modif_enr = $intervention->date_modif_enr;
	$lieurdvfk = $intervention->lieurdvfk;
	$interpretefk = $intervention->interpretefk;
	$demandefk = $intervention->demandefk;
	$nb_usagers = $intervention->nb_usagers;
	$heure_arrivee = $intervention->heure_arrivee;
	$minutes_arrivee = $intervention->minutes_arrivee;
	$heure_depart = $intervention->heure_depart;
	$minutes_depart = $intervention->minutes_depart;
	$duree = $intervention->duree;
	$indisponibilite = $intervention->indisponibilite;
	$signature = $intervention->signature;
	$etat = $intervention->etat;

	// utf8
	mysqli_set_charset($conn, 'utf8');
	$resultat = false;
	$response = "";
	$mgsEnr = "";

	if ($maj) {
		$msg = "mises à jour";
		// Mise à jour Demande
		$queryEnregistrerDemande = "UPDATE interventions SET code_user_to_update=";
		$queryEnregistrerDemande .= "'" . $code_user_to_update . "',";
		$queryEnregistrerDemande .= "date_modif_enr='" . $date_modif_enr . "',";
		$queryEnregistrerDemande .= "interpretefk='" . $interpretefk . "',";
		$queryEnregistrerDemande .= "lieurdvfk='" . $lieurdvfk . "',";
		$queryEnregistrerDemande .= "demandefk='" . $demandefk . "',";
		$queryEnregistrerDemande .= "nb_usagers='" . $nb_usagers . "',";
		$queryEnregistrerDemande .= "heure_arrivee='" . $heure_arrivee . "',";
		$queryEnregistrerDemande .= "minutes_arrivee='" . $minutes_arrivee . "',";
		$queryEnregistrerDemande .= "heure_depart='" . $heure_depart . "',";
		$queryEnregistrerDemande .= "minutes_depart='" . $minutes_depart . "',";
		$queryEnregistrerDemande .= "indisponibilite='" . $indisponibilite . "',duree='" . $duree . "',";
		$queryEnregistrerDemande .= "signature='" . $signature . "',etat='" . $etat . "'";
		$queryEnregistrerDemande .= " WHERE id='" . $idEnr . "'";
		// Mise à jour de la demande
		$resultat = mysqli_query($conn, $queryEnregistrerDemande);
	} else {
		$msg = "enregistrées";
		// Création de la demande
		$queryEnregistrerDemande = "INSERT INTO interventions(code_user_to_create,date_crea_enr,lieurdvfk,";
		$queryEnregistrerDemande .= "interpretefk,demandefk,nb_usagers,heure_arrivee,";
		$queryEnregistrerDemande .= "minutes_arrivee,heure_depart,minutes_depart,indisponibilite,";
		$queryEnregistrerDemande .= "signature,duree,etat)";
		$queryEnregistrerDemande .= " VALUES('" . $code_user_to_create . "','" . $date_crea_enr . "',";
		$queryEnregistrerDemande .= "'" . $lieurdvfk . "',";
		$queryEnregistrerDemande .= "'" . $interpretefk . "', '" . $demandefk . "',";
		$queryEnregistrerDemande .= "'" . $nb_usagers . "', '" . $heure_arrivee . "',";
		$queryEnregistrerDemande .= "'" . $minutes_arrivee . "', '" . $heure_depart . "',";
		$queryEnregistrerDemande .= "'" . $minutes_depart . "', '" . $indisponibilite . "',";
		$queryEnregistrerDemande .= "'" . $signature . "','" . $duree . "','EN_COURS')";
		$resultat = mysqli_query($conn, $queryEnregistrerDemande);
	}

	if ($resultat) {
		$mgsEnr .= 'Les informations de l\'intervention ont été ' . $msg . ' avec succès.';
	} else {
		$mgsEnr .= 'Echec lors de la mise à jour de l\'intervention. ' . $queryEnregistrerDemande . ' ' . mysqli_error($conn);
	}
	$response = $mgsEnr;

	return $response;
}

function removeIntervention($id)
{
	global $conn;
	// Supprimer contrat
	$queryContrat = "DELETE FROM interventions WHERE id=" . $id . "";
	mysqli_query($conn, $queryContrat);
}
