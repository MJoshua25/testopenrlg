<?php
	function getServices($sitefk)
	{
		global $conn;
		$queryService = "SELECT id,code,libelle FROM services where sitefk=".$sitefk."";		 
		$data = array();
		$resultService = mysqli_query($conn, $queryService);
		if($resultService){			
			while($row = mysqli_fetch_array($resultService))
			{			
				$nestedData = array();
				$nestedData["id"] = $row["id"];
				$nestedData["code"] = $row["code"];
				$nestedData["libelle"] = utf8_encode($row["libelle"]);			
				$data[] = $nestedData;
			}
		}
		return $data;
	}

	function getServiceMaxId()
	{
		$resultat = 1;
		global $conn;
		$query = mysqli_query($conn,"SELECT max(id) as nbMax FROM services");		
		$valeur = mysqli_fetch_assoc($query);
		if($valeur['nbMax'] != NULL) $resultat = $valeur['nbMax'];

		return $resultat;
	}

	function getServiceByCode($code)
	{
		global $conn;
		$query = "SELECT id,code,libelle FROM services where code='".$code."'";		
		
		$result = mysqli_query($conn, $query);		
		$service = new Service();
		while($row = mysqli_fetch_array($result))
		{	
			$service->id = $row["id"];					
			$service->code = $row["code"];
			$service->libelle = utf8_encode($row["libelle"]);							
		}
				
		return $service;
	}

	function getServiceById($id)
	{
		global $conn;
		$queryById = "SELECT id,code,libelle FROM services where id='".$id."'";		
		
		$result = mysqli_query($conn, $queryById);		
		$service = new Service();
		while($row = mysqli_fetch_array($result))
		{	
			$service->id = $row["id"];					
			$service->code = $row["code"];
			$service->libelle = utf8_encode($row["libelle"]);							
		}				
		return $service;
	}

	function enregistrerService(Service $service, $maj=false)
	{
		global $conn;
		$code = $service->code;
		$idService = $service->id;
		$libelle = $service->libelle;
		$sitefk = $service->sitefk;
				
		$msg = "";
		if($maj){
			$msg = "mises";
			$query = "UPDATE sites SET libelle='".$libelle."' WHERE code='".$code."'";
		} else {
			// Création du code
			$code = getServiceMaxId()."_SRV_".$sitefk;
			$msg = "enrégistrées";
			$query = "INSERT INTO services(code,libelle,sitefk) VALUES('".$code."', '".$libelle."',";
			$query .= "".$sitefk.")";
		}
		// utf8
		mysqli_set_charset($conn,'utf8');			
		if(mysqli_query($conn, $query))
		{
			$response[] = 'Les informations du service ont été '.$msg.' avec succès.';
			if(!$maj){
				$idService = getServiceMaxId();
			}
		} else{
			$response[] = 'Echec lors de la mise à jour du du service.'. mysqli_error($conn);
		}
		$response[] = $idService;
		$response[] = $code;				
		return $response;
	}

	function isServiceExiste($libelle, $sitefk){
		global $conn;
		$queryById = "SELECT * FROM services where libelle = '".$libelle."'";
		$queryById .= " and sitefk='".$sitefk."'";		
		if(mysqli_num_rows (mysqli_query($conn, $queryById))>0){
			return 1;
		}
		return 0;
	}

	function removeService($id)
	{
		global $conn;
		// Supprimer unitefonctionnelle
		$queryUniteFonctionnelle = "DELETE FROM unitefonctionnelles WHERE servicefk ";
		$queryUniteFonctionnelle .= "in (select id from services where id=".$id.")";		
		mysqli_query($conn,$queryUniteFonctionnelle);

		// Supprimer service
		$queryServices = "DELETE FROM services WHERE id = ".$id."";		
		mysqli_query($conn,$queryServices);
	}
?>