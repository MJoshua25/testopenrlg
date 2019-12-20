<?php
	function getSites($structurefk)
	{
		global $conn;
		$querySite = "SELECT code,libelle,typesite,ville,adresse1,adresse2,code_postal,email,telephone,structurefk FROM sites where structurefk=".$structurefk."";		
		$resultSite = mysqli_query($conn, $querySite);
		$data = array();
		if($resultSite){
			while($row = mysqli_fetch_array($resultSite))
			{			
				$nestedData = array();
				$nestedData["code"] = $row["code"];
				$nestedData["libelle"] = utf8_encode($row["libelle"]);
				$nestedData["typesite"] = $row["typesite"];			
				$nestedData["adresse1"] = utf8_encode($row["adresse1"]);
				$nestedData["adresse2"] = utf8_encode($row["adresse2"]);
				$nestedData["code_postal"] = $row["code_postal"];
				$nestedData["email"] = $row["email"];
				$nestedData["telephone"] = $row["telephone"];
				$nestedData["ville"] = utf8_encode($row["ville"]);
				$nestedData["structurefk"] = $row["structurefk"];
				$data[] = $nestedData;
			}
		}						
		return $data;
	}

	function getSiteMaxId()
	{
		global $conn;
		$resultat = 1;		
		$query = mysqli_query($conn,"SELECT max(id) as nbMax FROM sites");		
		$valeur = mysqli_fetch_assoc($query);
		if($valeur['nbMax'] != NULL) $resultat = $valeur['nbMax'];

		return $resultat;
	}

	function getSiteByCode($code)
	{
		global $conn;
		$query = "SELECT id,code,libelle,typesite,ville,adresse1,adresse2,";
		$query .= "code_postal,email,telephone,fax,structurefk FROM sites where code='".$code."'";		
		
		$result = mysqli_query($conn, $query);		
		$site = new Site();
		while($row = mysqli_fetch_array($result))
		{
			$site->id = $row["id"];		
			$site->code = $row["code"];
			$site->libelle = utf8_encode($row["libelle"]);
			$site->typesite = $row["typesite"];			
			$site->adresse1 = utf8_encode($row["adresse1"]);
			$site->adresse2 = utf8_encode($row["adresse2"]);
			$site->code_postal = $row["code_postal"];
			$site->email = $row["email"];
			$site->telephone = $row["telephone"];
			$site->fax = $row["fax"];
			$site->ville = utf8_encode($row["ville"]);
			$site->structurefk = $row["structurefk"];					
		}
				
		return $site;
	}

	function getSiteByInfos($id, $code, $libelle, $adresse1, $code_postal, $ville,$structurefk)
	{		
		$site = new Site();
		$site->id = $id;
		$site->code = $code;
		$site->libelle = $libelle;
		$site->adresse1 = $adresse1;
		$site->code_postal = $code_postal;
		$site->ville = $ville;
		$site->structurefk = $structurefk;
				
		return $site;
	}

	function enregistrerSite(Site $site, $maj=false)
	{
		global $conn;
		$response = array();
		$idSite = $site->id;
		$code = $site->code;
		$libelle = $site->libelle;		
		$adresse1 = $site->adresse1;		
		$code_postal = $site->code_postal;		
		$ville = strtoupper($site->ville);
		$structurefk = $site->structurefk;
		
		$msg = "";
		if($maj){
			$msg = "mises";
			$queryEnregistrerSite = "UPDATE sites SET libelle='".$libelle."',adresse1='".$adresse1."',";
			$queryEnregistrerSite .= "code_postal='".$code_postal."',ville='".$ville."' WHERE code='".$code."'";
		} else {
			// Création du code
			$code = getSiteMaxId()."_SIT_".$structurefk;
			$msg = "enrégistrées";
			$queryEnregistrerSite = "INSERT INTO sites(code,libelle,adresse1,code_postal,ville,structurefk) VALUES('".$code."',";
			$queryEnregistrerSite .= "'".$libelle."','".$adresse1."','".$code_postal."','".$ville."',".$structurefk.")";
		}
		// utf8
		mysqli_set_charset($conn,'utf8');		
		$resultat = mysqli_query($conn, $queryEnregistrerSite);
		$msgEnr = "";
		if($resultat)
		{
			$msgEnr = 'Les informations du site ont été '.$msg.' avec succès.';
			if(!$maj){
				$idSite = getSiteMaxId();
			}			
		} else{
			$msgEnr = 'Echec lors de la mise à jour du du site.'. mysqli_error($conn);
		}
		$response[] = $msgEnr;
		$response[] = $idSite;
		$response[] = $code;
		
		return $response;
	}

	function removeSite($id)
	{
		global $conn;
		// Supprimer unitefonctionnelle
		$queryUniteFonctionnelle = "DELETE FROM unitefonctionnelles WHERE servicefk ";
		$queryUniteFonctionnelle .= "in (select id from services where sitefk=".$id.")";		
		mysqli_query($conn,$queryUniteFonctionnelle);

		// Supprimer service
		$queryServices = "DELETE FROM services WHERE sitefk ";
		$queryServices .= "in (select id from services where sitefk=".$id.")";
		mysqli_query($conn,$queryServices);

		// Supprimer site
		$querySites = "DELETE FROM sites WHERE id=".$id."";	
		mysqli_query($conn,$querySites);
	}
?>