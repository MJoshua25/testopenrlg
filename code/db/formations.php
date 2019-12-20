<?php
	function getFormations($idInterprete, $typeFormation){
		global $conn;
		$queryFormations = "SELECT formations.id as id, formations.date_formation as date_formation,";
		$queryFormations .= " formations.sujet as sujet,formations.type_formation as type_formation,";
		$queryFormations .= " formations.analyse_formation as analyse_formation";
		$queryFormations .= " FROM formations, personne where formations.personnefk = personne.id";		
		$queryFormations .= " and formations.personnefk = ".$idInterprete."";					

		$data = array();
		$resultFormations = mysqli_query($conn, $queryFormations);		
		while($row = mysqli_fetch_array($resultFormations))
		{
			$nestedData = array();
			$nestedData["id"] = $row["id"];			
			$nestedData["date_formation"] = $row["date_formation"];			
			$nestedData["sujet"] = $row["sujet"];
			$nestedData["type_formation"] = $typeFormation[$row["type_formation"]];
			$nestedData["analyse_formation"] = $row["analyse_formation"];
			$data[] = $nestedData;
		}
		
		return $data;
	}
	
	function enregistrerFormation(Formation $formation, $maj=false)
	{
		global $conn;
		$response = array();	
		$code_user_to_create = $formation->code_user_to_create;
		$code_user_to_update = $formation->code_user_to_update;
		$date_crea_enr = $formation->date_crea_enr;	
		$date_modif_enr = $formation->date_modif_enr;
		$date_formation= $formation->date_formation;;
		$sujet= $formation->sujet;	
		$type_formation= $formation->type_formation;;	
		$analyse_formation= $formation->analyse_formation;
		$personnefk = $formation->personnefk;
		
		// utf8
		mysqli_set_charset($conn,'utf8');
		
		if($maj){
			$msg = "mises à jour";
			$queryEnregistrerContrat = "UPDATE formations SET code_user_to_update=";
			$queryEnregistrerContrat .= "'".$code_user_to_update."',";
			$queryEnregistrerContrat .= "date_modif_enr='".$date_modif_enr."',";
			$queryEnregistrerContrat .= "date_formation='".$date_formation."',";
			$queryEnregistrerContrat .= "sujet='".$sujet."',";
			$queryEnregistrerContrat .= "type_formation='".$type_formation."',";
			$queryEnregistrerContrat .= "analyse_formation='".$analyse_formation."'";
			$queryEnregistrerContrat .= " WHERE personnefk='".$personnefk."'";			
		} else {
			$msg = "enregistrées";
			// Création du code
			$queryEnregistrerContrat = "INSERT INTO formations(code_user_to_create,date_crea_enr,";
			$queryEnregistrerContrat .= "date_formation,sujet,type_formation,analyse_formation,";			
			$queryEnregistrerContrat .= "personnefk)";
			$queryEnregistrerContrat .= " VALUES('".$code_user_to_create."','".$date_crea_enr."',";
			$queryEnregistrerContrat .= "'".$date_formation."', '".$sujet."',";
			$queryEnregistrerContrat .= "'".$type_formation."', '".$analyse_formation."',";
			$queryEnregistrerContrat .= "'".$personnefk."')";
		}
		$resultat = mysqli_query($conn, $queryEnregistrerContrat);
		$mgsEnr = "";
		if($resultat){
			$mgsEnr = 'Les informations de la formation ont été '.$msg.' avec succès.';						
		} else {
			$mgsEnr = 'Echec lors de la mise à jour du de la formation.'. mysqli_error($conn);
		}
		$response = $mgsEnr;
			
		return $response;
	}

	function getFormationByCode($code)
	{
		global $conn;
		$queryContratByCode = "SELECT * FROM formations where id='".$code."'";		
		
		$result = mysqli_query($conn, $queryContratByCode);		
		$formation = new Formation();
		while($row = mysqli_fetch_array($result))
		{	
			$formation->id = $row["id"];					
			$formation->date_formation = $row["date_formation"];
			$formation->sujet = $row["sujet"];			
			$formation->type_formation = $row["type_formation"];
			$formation->analyse_formation = $row["analyse_formation"];
			$formation->personnefk = $row["personnefk"];
		}
				
		return $formation;
	}

	function removeFormation($id)
	{
		global $conn;
		// Supprimer contrat
		$queryContrat = "DELETE FROM formations WHERE id=".$id."";		
		mysqli_query($conn,$queryContrat);
	}
?>