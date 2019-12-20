<?php
	function getStructures($typeorganisme,$typestructure)
	{
		global $conn;
		$queryStructures = "SELECT id,code,libelle,typeorganisme,typestructure,ville,adresse1,";
		$queryStructures .= " adresse2,code_postal,email,telephone,fax FROM structures";
		$queryStructures .= " order by libelle";		
		
		$result = mysqli_query($conn, $queryStructures);					
		while($row = mysqli_fetch_array($result))
		{			
			$nestedData = array();
			$nestedData["id"] = $row["id"];
			$nestedData["code"] = $row["code"];
			$nestedData["libelle"] = utf8_encode($row["libelle"]);
			$nestedData["typeorganisme"] = $typeorganisme[$row["typeorganisme"]];
			$nestedData["typestructure"] = $typestructure[$row["typestructure"]];
			$nestedData["adresse1"] = utf8_encode($row["adresse1"]);
			$nestedData["adresse2"] = utf8_encode($row["adresse2"]);
			$nestedData["code_postal"] = $row["code_postal"];
			$nestedData["email"] = $row["email"];
			$nestedData["telephone"] = $row["telephone"];
			$nestedData["fax"] = $row["fax"];
			$nestedData["ville"] = utf8_encode($row["ville"]);
			$data[] = $nestedData;
		}
		
		return $data;
	}

	function getStructuresJson($typeorganisme,$typestructure)
	{		
		$json_data = array("data" => getStructures($typeorganisme,$typestructure));		
		return json_encode($json_data,JSON_UNESCAPED_SLASHES);
	}

	function getMaxId()
	{
		global $conn;
		$queryMaxId = mysqli_query($conn,"SELECT max(id) as nbMax FROM structures");		
		$valeur = mysqli_fetch_assoc($queryMaxId);
				
		return $valeur['nbMax'];
	}

	function getStructureByCode($code)
	{
		global $conn;
		$queryStructureByCode = "SELECT id,code,libelle,typeorganisme,typestructure,ville,adresse1,adresse2,";
		$queryStructureByCode .= "code_postal,email,telephone,fax FROM structures where code='".$code."'";		
		
		$result = mysqli_query($conn, $queryStructureByCode);		
		$structure = new Structure();
		while($row = mysqli_fetch_array($result))
		{	
			$structure->id = $row["id"];					
			$structure->code = $row["code"];
			$structure->libelle = utf8_encode($row["libelle"]);
			$structure->typeorganisme = $row["typeorganisme"];
			$structure->typestructure = $row["typestructure"];
			$structure->adresse1 = utf8_encode($row["adresse1"]);
			$structure->adresse2 = utf8_encode($row["adresse2"]);
			$structure->code_postal = $row["code_postal"];
			$structure->email = $row["email"];
			$structure->telephone = $row["telephone"];
			$structure->fax = $row["fax"];
			$structure->ville = utf8_encode($row["ville"]);					
		}
				
		return $structure;
	}

	function enregistrerStructure(Structure $structure, $maj=false)
	{
		global $conn;
		$response = array();
		$idStruct = $structure->id;
		$code = $structure->code;
		$libelle = $structure->libelle;
		$typeorganisme = $structure->typeorganisme;
		$typestructure = $structure->typestructure;
		$adresse1 = $structure->adresse1;
		$adresse2 = $structure->adresse2;
		$code_postal = $structure->code_postal;  
		$email = $structure->email;
		$telephone = $structure->telephone;
		$fax = $structure->fax;
		$ville = strtoupper($structure->ville);
				
		if($maj){
			$msg = "mises à jour";
			$queryEnregistrerStructure = "UPDATE structures SET libelle='".$libelle."',typeorganisme='".$typeorganisme."',";
			$queryEnregistrerStructure .= "typestructure='".$typestructure."',adresse1='".$adresse1."',";
			$queryEnregistrerStructure .= "adresse2='".$adresse2."',code_postal='".$code_postal."',email='".$email."',";
			$queryEnregistrerStructure .= "telephone='".$telephone."',fax='".$fax."',ville='".$ville."'";
			$queryEnregistrerStructure .= " WHERE code='".$code."'";
		} else {
			// Création du code			
			$code = "".getMaxId()."_RLG_".substr("$code_postal", 0, 2);
			$msg = "enrégistrées";
			$queryEnregistrerStructure = "INSERT INTO structures(code,libelle,typeorganisme,typestructure,adresse1,adresse2,";
			$queryEnregistrerStructure .= "code_postal,email,telephone,fax,ville) VALUES('".$code."', '".$libelle."',";
			$queryEnregistrerStructure .= "'".$typeorganisme."', '".$typestructure."', '".$adresse1."', '".$adresse2."',";
			$queryEnregistrerStructure .= "'".$code_postal."','".$email."', '".$telephone."', '".$fax."', '".$ville."')";
		}
		mysqli_set_charset($conn,'utf8');
		$resultat = mysqli_query($conn, $queryEnregistrerStructure);
		$mgsEnr = "";
		if($resultat)
		{
			$mgsEnr = 'Les informations de la structure ont été '.$msg.' avec succès.';			
			if(!$maj){
				$idStruct = getMaxId();
			}			
		}
		else
		{
			$mgsEnr = 'Echec lors de la mise à jour du de la structure.'. mysqli_error($conn);
		}
		$response[] = $mgsEnr;
		$response[] = $idStruct;
		$response[] = $code;

		// Si la structure n'est pas de type HOPITAUX supprimer les sites/services/uf
		if($typestructure != "HOPITAUX"){
			removeStructure($idStruct, false);
		}		
		return $response;
	}

	function getStructureByInfos($id, $code, $libelle, $typeorganisme, $typestructure, 
	$adresse1, $adresse2, $code_postal, $email, $telephone, $fax, $ville)
	{		
		$structure = new Structure();
		$structure->id = $id;
		$structure->code = $code;
		$structure->libelle = $libelle;
		$structure->typeorganisme = $typeorganisme;
		$structure->typestructure = $typestructure;
		$structure->adresse1 = $adresse1;
		$structure->adresse2 = $adresse2;
		$structure->code_postal = $code_postal;
		$structure->email = $email;
		$structure->telephone = $telephone;
		$structure->fax = $fax;
		$structure->ville = $ville;	
				
		return $structure;
	}

	function getMessagesErreurs($code, $arryPost){
		$message_erreur = array();

		// Vérification des infos
        // libelle
        if(empty($arryPost['libelle'])){
            $message_erreur[] = "le nom de l'organisme";
        }
        // typeorganisme
        if(empty($arryPost['typeorganisme'])){
            $message_erreur[] = "le type d'organisme";
        }
        // typestructure
        if(empty($arryPost['typestructure'])){
            $message_erreur[] = "le type de structure";
        }
        // adresse1
        if(empty($arryPost['adresse'])){
            $message_erreur[] = "l'adresse";
        }        
        // code_postal
        if(empty($arryPost['codepostal'])){
            $message_erreur[] = "le code postal";
        } 
        // code_postal
        if(empty($arryPost['codepostal'])){
            $message_erreur[] = "le code postal";
        }
        // Ville
        if(empty($arryPost['ville'])){
            $message_erreur[] = "la localité";
		}
		
		return $message_erreur;
	}

	function removeStructure($id, $avecStruct)
	{
		global $conn;
		// Supprimer unitefonctionnelle
		$queryUniteFonctionnelle = "DELETE FROM unitefonctionnelles WHERE servicefk ";
		$queryUniteFonctionnelle .= "in (select id from services where sitefk ";
		$queryUniteFonctionnelle .= "in (select id from sites where structurefk=".$id."))";
		mysqli_query($conn,$queryUniteFonctionnelle);

		// Supprimer service
		$queryServices = "DELETE FROM services WHERE sitefk ";
		$queryServices .= "in (select id from sites where structurefk=".$id.")";
		mysqli_query($conn,$queryServices);

		// Supprimer site
		$querySites = "DELETE FROM sites WHERE structurefk=".$id."";	
		mysqli_query($conn,$querySites);

		if($avecStruct){
			// Supprimer structure
			$queryStructures = "DELETE FROM structures WHERE id=".$id."";		
			mysqli_query($conn,$queryStructures);
		}
	}
?>