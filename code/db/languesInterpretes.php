<?php
	
	function getLanguesInterpreteByInfos($id, $libelle, $langue_orale, $langue_ecrite, $interpretefk)
	{	
		$languesInterprete = new LanguesInterprete();
		$languesInterprete->id = $id;
		$languesInterprete->libelle = $libelle;
		$languesInterprete->langue_orale = $langue_orale;
		$languesInterprete->langue_ecrite = $langue_ecrite;	
		$languesInterprete->interpretefk = $interpretefk;
						
		return $languesInterprete;
	}

	function removeLanguesInterprete($personnefk, $languefk)
	{
		global $conn;

		// Supprimer LanguesInterprete
		$querylanguesInterpretes = "DELETE FROM  langues_interprete WHERE";
		$querylanguesInterpretes .= " personnefk=".$personnefk." and languefk=".$languefk."";				
		mysqli_query($conn,$querylanguesInterpretes);
	}
	
	function enregistrerLanguesInterprete(LanguesInterprete $languesInterprete, $maj=false, $lgpk=false)
	{
		global $conn;
		$response = array();
		$idLanguesInterprete = $languesInterprete->id;		
		$languefk = $languesInterprete->languefk;
		$langue_orale = $languesInterprete->langue_orale;
		$langue_ecrite = $languesInterprete->langue_ecrite;
		$interpretefk = $languesInterprete->interpretefk;
		$date_crea_enr = $languesInterprete->date_crea_enr;
		$date_modif_enr = $languesInterprete->date_modif_enr;
		$code_user_to_create = $languesInterprete->code_user_to_create;
		$code_user_to_update = $languesInterprete->code_user_to_update;

		if($maj){
			$msg = "mises à jour";
			$queryEnregistrerLangue = "UPDATE langues_interprete SET languefk='".$languefk."',";						
			$queryEnregistrerLangue .= "langue_orale='".$langue_orale."',";
			$queryEnregistrerLangue .= "langue_ecrite='".$langue_ecrite."',";
			$queryEnregistrerLangue .= "personnefk='".$interpretefk."',";
			$queryEnregistrerLangue .= "date_modif_enr='".$date_modif_enr."',";
			$queryEnregistrerLangue .= "code_user_to_update='".$code_user_to_update."'";			
			if($lgpk){
				$queryEnregistrerLangue .= " WHERE personnefk= ".$interpretefk." and ";
				$queryEnregistrerLangue .= " languefk= ".$languefk."";
			} else {
				$queryEnregistrerLangue .= " WHERE id='".$idLanguesInterprete."'";
			}
		} else {					
			$msg = "enrégistrées";
			$queryEnregistrerLangue = "INSERT INTO langues_interprete(personnefk,langue_orale,langue_ecrite,";
			$queryEnregistrerLangue .= "languefk,date_crea_enr,code_user_to_create)";
			$queryEnregistrerLangue .= " VALUES('".$interpretefk."','".$langue_orale."',";
			$queryEnregistrerLangue .= "'".$langue_ecrite."','".$languefk."',";
			$queryEnregistrerLangue .= "'".$date_crea_enr."', '".$code_user_to_create."')";
		}

		// utf8
		mysqli_set_charset($conn,'utf8');
		$resultat = mysqli_query($conn, $queryEnregistrerLangue);
		$mgsEnr = "";
		if($resultat){
			$mgsEnr = "Les informations de la langue de l'interprète ont été ".$msg." avec succès.";
			if(!$maj){
				$idLanguesInterprete = mysqli_insert_id($conn);
			}
		} else {
			$mgsEnr = "Echec lors de la mise à jour de la langue de l'interprète.". mysqli_error($conn);
			$mgsEnr .= "".$queryEnregistrerLangue."";
		}
		$response[] = $mgsEnr;
		$response[] = $idLanguesInterprete;
			
		return $response;
	}

	function getLanguesInterpreteByPersoLangue($personnefk,$languefk)
	{
		global $conn;
		$queryContratByCode = "SELECT * FROM langues_interprete where personnefk=".$personnefk."";		
		$queryContratByCode .= " and languefk=".$languefk."";
		
		$result = mysqli_query($conn, $queryContratByCode);		
		$languesInterprete = new LanguesInterprete();
		while($row = mysqli_fetch_array($result))
		{	
			$languesInterprete->id = $row["id"];			
			$languesInterprete->languefk = $row["languefk"];			
			$languesInterprete->langue_orale = $row["langue_orale"];
			$languesInterprete->langue_ecrite = $row["langue_ecrite"];
			$languesInterprete->interpretefk = $row["personnefk"];			
		}
				
		return $languesInterprete;
	}

?>