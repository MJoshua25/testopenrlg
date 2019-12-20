<?php
	function getMarches($typemarche,$isJson=false)
	{
		global $conn;
		$queryMarches = "SELECT id,code,libelle,typecontrat,prix,date_debut,date_fin FROM marches";		
		$result = mysqli_query($conn, $queryMarches);		
		$data = array();					
		while($row = mysqli_fetch_array($result))
		{			
			$nestedData = array();
			$nestedData["id"] = $row["id"];
			$nestedData["code"] = $row["code"];
			$nestedData["libelle"] = utf8_encode($row["libelle"]);
			$nestedData["typecontrat"] = $typemarche[$row["typecontrat"]];
			$nestedData["prix"] = $row["prix"];			
			$dateDebut = $row["date_debut"];
			$dateFin = $row["date_fin"];			
			if($isJson){
				if($dateDebut != '0000-00-00 00:00:00'){
					$dateDebut=date("d/m/Y",strtotime($dateDebut));
				} else {
					$dateDebut= "";
				}
				if($dateFin != '0000-00-00 00:00:00'){
					$dateFin=date("d/m/Y",strtotime($dateFin));
				} else {
					$dateFin="";
				}
			}
			$nestedData["date_fin"] = $dateFin;
			$nestedData["date_debut"] = $dateDebut;							
			$data[] = $nestedData;
		}		
		
		return $data;
	}

	function getMarchesJson($typemarche)
	{			
		$json_data = array("data" => getMarches($typemarche, true));		
		return json_encode($json_data,JSON_UNESCAPED_SLASHES);
	}

	function getMarcheByCode($code)
	{
		global $conn;
		$queryMarcheByCode = "SELECT id,code,libelle,typecontrat,prix,date_debut,date_fin";
		$queryMarcheByCode .= " FROM marches where code='".$code."'";		
		
		$result = mysqli_query($conn, $queryMarcheByCode);		
		$marche = new Marche();
		while($row = mysqli_fetch_array($result))
		{	
			$marche->id = $row["id"];					
			$marche->code = $row["code"];
			$marche->libelle = utf8_encode($row["libelle"]);
			$marche->typecontrat = $row["typecontrat"];
			$marche->prix = $row["prix"];
			$marche->date_debut = $row["date_debut"];
			$marche->date_fin = $row["date_fin"];					
		}
				
		return $marche;
	}

	function getMarcheByInfos($id, $code, $libelle, $typecontrat, $prix, $date_debut, $date_fin)
	{
		$marche = new Marche();
		$marche->id = $id;
		$marche->code = $code;
		$marche->libelle = $libelle;
		$marche->typecontrat = $typecontrat;
		$marche->prix = $prix;
		$marche->date_debut = $date_debut;
		$marche->date_fin = $date_fin;	
		
		return $marche;
	}

	function getMaxMarcheId()
	{
		global $conn;
		$queryMaxId = mysqli_query($conn,"SELECT max(id) as nbMax FROM marches");		
		$valeur = mysqli_fetch_assoc($queryMaxId);
				
		return $valeur['nbMax'];
	}

	function enregistrerMarche(Marche $marche, $maj=false)
	{
		global $conn;
		$response = array();
		$idMrc = $marche->id;
		$code = $marche->code;
		$libelle = $marche->libelle;
		$typecontrat = $marche->typecontrat;
		$prix = $marche->prix;
		$date_debut = $marche->date_debut;
		$date_fin = $marche->date_fin;
				
		if($maj){
			$msg = "mises à jour";
			$queryEnregistrerStructure = "UPDATE marches SET libelle='".$libelle."',typecontrat='".$typecontrat."',";			
			$queryEnregistrerStructure .= "date_debut='".$date_debut."',date_fin='".$date_fin."',";
			$queryEnregistrerStructure .= "prix=".$prix." WHERE code='".$code."'";
		} else {
			// Création du code			
			$code = "".getMaxMarcheId()."_RLG_MCP";
			$msg = "enrégistrées";
			$queryEnregistrerStructure = "INSERT INTO marches(code,libelle,typecontrat,prix,";
			$queryEnregistrerStructure .= "date_debut,date_fin) VALUES('".$code."', '".$libelle."',";
			$queryEnregistrerStructure .= "'".$typecontrat."','".$prix."',";
			$queryEnregistrerStructure .= "'".$date_debut."', '".$date_fin."')";
		}
		// utf8
		mysqli_set_charset($conn,'utf8');
		$resultat = mysqli_query($conn, $queryEnregistrerStructure);
		$mgsEnr = "";
		if($resultat)
		{
			$mgsEnr = 'Les informations du marché ont été '.$msg.' avec succès.';			
			if(!$maj){				
				$idMrc = getMaxMarcheId();
			}			
		} else {
			$mgsEnr = 'Echec lors de la mise à jour du marché.'. mysqli_error($conn);
		}
		$response[] = $mgsEnr;
		$response[] = $idMrc;
		$response[] = $code;
		
		return $response;
	}

	function removeMarche($id)
	{
		global $conn;

		// Supprimer langues
		$querylangues = "DELETE FROM langues WHERE lotlanguefk ";
		$querylangues .= "in (select id from lotslangues where marchefk=".$id.")";
		mysqli_query($conn,$querylangues);

		// Supprimer lotslangues
		$querylotslangues = "DELETE FROM lotslangues WHERE marchefk=".$id."";	
		mysqli_query($conn,$querylotslangues);

		// Supprimer marches
		$querymarches = "DELETE FROM marches WHERE id=".$id."";		
		mysqli_query($conn,$querymarches);
	}
?>