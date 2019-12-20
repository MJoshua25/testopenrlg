<?php
	function getLotsLangues()
	{
		global $conn;
		$querylotsLangues = "select lotslangues.id as id, lotslangues.code as code,lotslangues.libelle as libelle,";		
		$querylotsLangues .= " marches.libelle as libmarche from lotslangues, marches";
		$querylotsLangues .= " where lotslangues.marchefk = marches.id";

		$resultLotsLangues = mysqli_query($conn, $querylotsLangues);
		$data = array();					
		while($row = mysqli_fetch_array($resultLotsLangues))
		{			
			$nestedData = array();
			$nestedData["id"] = $row["id"];
			$nestedData["code"] = $row["code"];
			$nestedData["libelle"] = utf8_encode($row["libelle"]);
			$nestedData["libmarche"] = utf8_encode($row["libmarche"]);						
			$data[] = $nestedData;
		}		
		return $data;
	}

	function getLotsLanguesJson()
	{
		$json_data = array("data" => getLotsLangues());		
		return json_encode($json_data,JSON_UNESCAPED_SLASHES);
	}

	function getLotLanguesByCode($code)
	{
		global $conn;
		$queryLotLanguesByCode = "SELECT id,code,libelle,marchefk";
		$queryLotLanguesByCode .= " FROM lotslangues where code='".$code."'";		
		
		$result = mysqli_query($conn, $queryLotLanguesByCode);		
		$lotlangues = new LotLangues();
		while($row = mysqli_fetch_array($result))
		{	
			$lotlangues->id = $row["id"];					
			$lotlangues->code = $row["code"];
			$lotlangues->libelle = utf8_encode($row["libelle"]);
			$lotlangues->marchefk = $row["marchefk"];							
		}
				
		return $lotlangues;
	}
	
	function getLotLanguesByInfos($id, $code, $libelle, $marchefk)
	{		
		$lotlangues = new LotLangues();
		$lotlangues->id = $id;
		$lotlangues->code = $code;
		$lotlangues->libelle = $libelle;
		$lotlangues->marchefk = $marchefk;
				
		return $lotlangues;
	}

	function getMaxLotLanguesId()
	{
		global $conn;
		$queryMaxId = mysqli_query($conn,"SELECT max(id) as nbMax FROM lotslangues");		
		$valeur = mysqli_fetch_assoc($queryMaxId);
				
		return $valeur['nbMax'];
	}

	function enregistrerLotLangues(LotLangues $lotLangues, $maj=false)
	{
		global $conn;
		$response = array();
		$idLotlgn = $lotLangues->id;
		$code = $lotLangues->code;
		$libelle = $lotLangues->libelle;		
		$marchefk = $lotLangues->marchefk;		
		if($maj){
			$msg = "mises à jour";
			$queryEnregistrerLotLangues = "UPDATE lotslangues SET libelle='".$libelle."',";			
			$queryEnregistrerLotLangues .= "marchefk=".$marchefk."";
			$queryEnregistrerLotLangues .= " WHERE code='".$code."'";
		} else {
			// Création du code			
			$code = "".getMaxLotLanguesId()."_RLG_LTLG";
			$msg = "enrégistrées";
			$queryEnregistrerLotLangues = "INSERT INTO lotslangues(code,libelle,marchefk)";
			$queryEnregistrerLotLangues .= " VALUES('".$code."', '".$libelle."',".$marchefk.")";			
		}
		// utf8
		mysqli_set_charset($conn,'utf8');		
		$resultat = mysqli_query($conn, $queryEnregistrerLotLangues);
		$mgsEnr = "";
		if($resultat)
		{
			$mgsEnr = 'Les informations du lot langues ont été '.$msg.' avec succès.';			
			if(!$maj){
				$idLotlgn = getMaxLotLanguesId();
			}			
		}
		else
		{
			$mgsEnr = 'Echec lors de la mise à jour du lot langues.'. mysqli_error($conn);
		}
		$response[] = $mgsEnr;
		$response[] = $idLotlgn;
		$response[] = $code;
		
		return $response;
	}

	function removeLotLangues($id)
	{
		global $conn;

		// Supprimer langues
		$querylangues = "DELETE FROM langues WHERE lotlanguefk=".$id."";
		mysqli_query($conn,$querylangues);

		// Supprimer lotslangues
		$querylotslangues = "DELETE FROM lotslangues WHERE id=".$id."";	
		mysqli_query($conn,$querylotslangues);
	}
?>