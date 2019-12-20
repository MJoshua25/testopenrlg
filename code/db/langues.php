<?php
	function getLangues(){
		global $conn;
		$querylotsLangues = "select langues.id as id, langues.code as code, langues.libelle as libelle,";		
		$querylotsLangues .= " lotslangues.libelle as liblotslang";
		$querylotsLangues .= " from langues, lotslangues where langues.lotlanguefk = lotslangues.id";		

		$resultLotsLangues = mysqli_query($conn, $querylotsLangues);
		$data = array();					
		while($row = mysqli_fetch_array($resultLotsLangues))
		{
			$nestedData = array();
			$nestedData["id"] = $row["id"];
			$nestedData["code"] = $row["code"];
			$nestedData["libelle"] = utf8_encode($row["libelle"]);			
			$nestedData["liblotslang"] = utf8_encode($row["liblotslang"]);						
			$data[] = $nestedData;
		}			
		
		return $data;
	}

	function getLanguesJson(){					
		$json_data = array("data" => getLangues());		
		return json_encode($json_data,JSON_UNESCAPED_SLASHES);
	}
	
	function getLangueByInfos($id, $code, $libelle, $lotlanguefk){		
		$langue = new Langue();
		$langue->id = $id;
		$langue->code = $code;
		$langue->libelle = $libelle;		
		$langue->lotlanguefk = $lotlanguefk;	

		return $langue;
	}

	function removeLangue($id)
	{
		global $conn;
		// Supprimer langues
		$querylangues = "DELETE FROM langues WHERE id=".$id."";
		mysqli_query($conn,$querylangues);
	}
	
	function getMaxLangueId(){
		global $conn;
		$queryMaxId = mysqli_query($conn,"SELECT max(id) as nbMax FROM langues");		
		$valeur = mysqli_fetch_assoc($queryMaxId);
		return $valeur['nbMax'];
	}
		
	function getLangueByCode($code)
	{
		global $conn;
		$queryLangueByCode = "SELECT id,code,libelle,lotlanguefk";
		$queryLangueByCode .= " FROM langues where code='".$code."'";		
		
		$result = mysqli_query($conn, $queryLangueByCode);		
		$langue = new Langue();
		while($row = mysqli_fetch_array($result))
		{	
			$langue->id = $row["id"];					
			$langue->code = $row["code"];
			$langue->libelle = utf8_encode($row["libelle"]);			
			$langue->lotlanguefk = $row["lotlanguefk"];							
		}
				
		return $langue;
	}

	function enregistrerLangue(Langue $langue, $maj=false)
	{
		global $conn;
		$response = array();
		$idLangue = $langue->id;
		$code = $langue->code;
		$libelle = $langue->libelle;		
		$lotlanguefk = $langue->lotlanguefk;			
				
		if($maj){
			$msg = "mises à jour";
			$queryEnregistrerLangue = "UPDATE langues SET libelle='".$libelle."',";						
			$queryEnregistrerLangue .= "lotlanguefk='".$lotlanguefk."'";
			$queryEnregistrerLangue .= " WHERE code='".$code."'";
		} else {
			// Création du code			
			$code = "".getMaxLangueId()."_RLG_LNG";
			$msg = "enrégistrées";
			$queryEnregistrerLangue = "INSERT INTO langues(code,libelle,lotlanguefk) ";
			$queryEnregistrerLangue .= " VALUES('".$code."', '".$libelle."',".$lotlanguefk.")";			
		}
		// utf8
		mysqli_set_charset($conn,'utf8');
		$resultat = mysqli_query($conn, $queryEnregistrerLangue);
		$mgsEnr = "";
		if($resultat){
			$mgsEnr = 'Les informations de la langue ont été '.$msg.' avec succès.';
			if(!$maj){
				$idLangue = getMaxLangueId();
			}
		} else {
			$mgsEnr = 'Echec lors de la mise à jour du de la langue.'. mysqli_error($conn);
		}
		$response[] = $mgsEnr;
		$response[] = $idLangue;
		$response[] = $code;
	
		return $response;
	}

	function getLanguesInterpreteByCode($code)
	{
		global $conn;
		$queryLanguesInterpreteByCode = "SELECT langues_interprete.id as id,langues.libelle as libelle,";
		$queryLanguesInterpreteByCode .= " langues_interprete.personnefk as personnefk,";
		$queryLanguesInterpreteByCode .= " langues_interprete.langue_orale as langue_orale,";
		$queryLanguesInterpreteByCode .= " langues_interprete.langue_ecrite as langue_ecrite,";
		$queryLanguesInterpreteByCode .= " langues_interprete.languefk as languefk";
		$queryLanguesInterpreteByCode .= " FROM langues, langues_interprete where";
		$queryLanguesInterpreteByCode .= " langues_interprete.personnefk='".$code."' and";
		$queryLanguesInterpreteByCode .= " langues_interprete.languefk=langues.id";
		$result = mysqli_query($conn, $queryLanguesInterpreteByCode);
		
		$datas = array();
		while($row = mysqli_fetch_array($result))
		{
			$langue = new LanguesInterprete();
			$langue->id = $row["id"];
			$langue->libelle = utf8_encode($row["libelle"]);
			$langue->langue_orale = utf8_encode($row["langue_orale"]);
			$langue->langue_ecrite = utf8_encode($row["langue_ecrite"]);
			$langue->languefk = $row["languefk"];
			$langue->personnefk = $row["personnefk"];
			$datas[] = $langue;
		}
		return $datas;
	}
?>