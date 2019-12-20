<?php
	function getContrats($idInterprete, $typeContrat, $typePeriodicite, $isJson){
		global $conn;
		$queryContrats = "SELECT contrats.id as id, contrats.typecontrat as typecontrat,";
		$queryContrats .= " contrats.nb_heures as nb_heures,contrats.periodicite as periodicite,";
		$queryContrats .= " contrats.date_contrat as date_contrat,";
		$queryContrats .= " contrats.date_medecin_travail as date_medecin_travail,";
		$queryContrats .= " contrats.date_entretien as date_entretien";
		$queryContrats .= " FROM contrats, personne where contrats.personnefk = personne.id";		
		$queryContrats .= " and contrats.personnefk = ".$idInterprete."";
		
		$data = array();
		$resultContrats = mysqli_query($conn, $queryContrats);		
		while($row = mysqli_fetch_array($resultContrats))
		{
			$nestedData = array();
			$nestedData["id"] = $row["id"];			
			$nestedData["nb_heures"] = $row["nb_heures"];
			$nestedData["periodicite"] = $typePeriodicite[$row["periodicite"]];
			$nestedData["typecontrat"] = $typeContrat[$row["typecontrat"]];			
			$date_contrat = $row["date_contrat"];
			$date_medecin_travail = $row["date_medecin_travail"];
			$date_entretien = $row["date_entretien"];			
			if($isJson){
				$date_contrat = date('d/m/Y', strtotime($date_contrat));
				$date_medecin_travail = date('d/m/Y', strtotime($date_medecin_travail));
				$date_entretien = date('d/m/Y', strtotime($date_entretien));
			}
			$nestedData["date_contrat"] = $date_contrat;
			$nestedData["date_medecin_travail"] = $date_medecin_travail;
			$nestedData["date_entretien"] = $date_entretien;
			$data[] = $nestedData;
		}
		
		return $data;
	}
	
	function getContratsJson($idInterprete, $typeContrat, $typePeriodicite){			
		$json_data = array("data" => getContrats($idInterprete, $typeContrat, $typePeriodicite,true));		
		return json_encode($json_data,JSON_UNESCAPED_SLASHES);
	}

	function getContratByCode($code)
	{
		global $conn;
		$queryContratByCode = "SELECT * FROM contrats where id='".$code."'";		
		
		$result = mysqli_query($conn, $queryContratByCode);		
		$contrat = new Contrat();
		while($row = mysqli_fetch_array($result))
		{	
			$contrat->id = $row["id"];					
			$contrat->date_contrat = $row["date_contrat"];
			$contrat->nb_heures = $row["nb_heures"];			
			$contrat->periodicite = $row["periodicite"];
			$contrat->typecontrat = $row["typecontrat"];
			$contrat->date_medecin_travail = $row["date_medecin_travail"];
			$contrat->date_entretien = $row["date_entretien"];
			$contrat->entretien_stagiaire = $row["entretien_stagiaire"];
			$contrat->personnefk = $row["personnefk"];								
		}
				
		return $contrat;
	}

	function enregistrerContrat(Contrat $contrat, $maj=false)
	{
		global $conn;
		$response = array();
		$id = $contrat->id;	
		$code_user_to_create = $contrat->code_user_to_create;
		$code_user_to_update = $contrat->code_user_to_update;
		$date_crea_enr = $contrat->date_crea_enr;	
		$date_modif_enr = $contrat->date_modif_enr;
		$date_contrat = $contrat->date_contrat;
		$nb_heures = $contrat->nb_heures;
		$periodicite = $contrat->periodicite;
		$typecontrat = $contrat->typecontrat;
		$date_medecin_travail = $contrat->date_medecin_travail;
		$date_entretien = $contrat->date_entretien;	
		$entretien_stagiaire = $contrat->entretien_stagiaire;
		$personnefk = $contrat->personnefk;

		// utf8
		mysqli_set_charset($conn,'utf8');
						
		if($maj){
			$msg = "mises à jour";
			$queryEnregistrerContrat = "UPDATE contrats SET code_user_to_update=";
			$queryEnregistrerContrat .= "'".$code_user_to_update."',";
			$queryEnregistrerContrat .= "date_modif_enr='".$date_modif_enr."',";
			$queryEnregistrerContrat .= "date_contrat='".$date_contrat."',";
			$queryEnregistrerContrat .= "nb_heures='".$nb_heures."',";
			$queryEnregistrerContrat .= "periodicite='".$periodicite."',";
			$queryEnregistrerContrat .= "typecontrat='".$typecontrat."',";
			$queryEnregistrerContrat .= "date_medecin_travail='".$date_medecin_travail."',";
			$queryEnregistrerContrat .= "date_entretien='".$date_entretien."',";
			$queryEnregistrerContrat .= "entretien_stagiaire='".$entretien_stagiaire."'";
			$queryEnregistrerContrat .= " WHERE id='".$id."'";			
		} else {
			$msg = "enregistrées";
			// Création du code
			$queryEnregistrerContrat = "INSERT INTO contrats(code_user_to_create,date_crea_enr,";
			$queryEnregistrerContrat .= "date_contrat,nb_heures,periodicite,typecontrat,";
			$queryEnregistrerContrat .= "date_medecin_travail,date_entretien,entretien_stagiaire,";
			$queryEnregistrerContrat .= "personnefk)";
			$queryEnregistrerContrat .= " VALUES('".$code_user_to_create."','".$date_crea_enr."',";
			$queryEnregistrerContrat .= "'".$date_contrat."', '".$nb_heures."',";
			$queryEnregistrerContrat .= "'".$periodicite."', '".$typecontrat."',";
			$queryEnregistrerContrat .= "'".$date_medecin_travail."','".$date_entretien."',";
			$queryEnregistrerContrat .= "'".$entretien_stagiaire."','".$personnefk."')";
		}
		$resultat = mysqli_query($conn, $queryEnregistrerContrat);
		$mgsEnr = "";
		if($resultat){
			$mgsEnr = 'Les informations du contrat ont été '.$msg.' avec succès.';						
		} else {
			$mgsEnr = 'Echec lors de la mise à jour du contrat.'. mysqli_error($conn);
		}
		$response = $mgsEnr;
			
		return $response;
	}

	function removeContrat($id)
	{
		global $conn;
		// Supprimer contrat
		$queryContrat = "DELETE FROM contrats WHERE id=".$id."";		
		mysqli_query($conn,$queryContrat);
	}
?>