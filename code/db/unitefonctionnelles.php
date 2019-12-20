<?php
function getUniteFonctionnelles($servicefk)
{
	global $conn;
	$queryUf = "SELECT id,code,libelle FROM unitefonctionnelles where servicefk=" . $servicefk . "";	
	$resultUf = mysqli_query($conn, $queryUf);
	$data = array();
	if ($resultUf) {
		while ($row = mysqli_fetch_array($resultUf)) {
			$nestedData = array();
			$nestedData["code"] = $row["code"];
			$nestedData["libelle"] = utf8_encode($row["libelle"]);
			$data[] = $nestedData;
		}
	}
	return $data;
}

function getUniteFonctionnellesBySite($sitefk)
{
	global $conn;
	$queryUfBySite = "SELECT id,code,libelle FROM unitefonctionnelles where servicefk in (";
	$queryUfBySite .= " select id from services where sitefk=" . $sitefk . ")";

	$resultUfBySite = mysqli_query($conn, $queryUfBySite);
	$data = array();
	while ($row = mysqli_fetch_array($resultUfBySite)) {
		$nestedData = array();
		$nestedData["id"] = $row["id"];
		$nestedData["code"] = $row["code"];
		$nestedData["libelle"] = utf8_encode($row["libelle"]);
		$data[] = $nestedData;
	}
	return $data;
}

function getUfMaxId()
{
	global $conn;
	$query = mysqli_query($conn, "SELECT max(id) as nbMax FROM unitefonctionnelles");
	$valeur = mysqli_fetch_assoc($query);

	return $valeur['nbMax'];
}

function getUfByCode($code)
{
	global $conn;
	$query = "SELECT code,libelle FROM unitefonctionnelles where code='" . $code . "'";

	$result = mysqli_query($conn, $query);
	$site = new Site();
	while ($row = mysqli_fetch_array($result)) {
		$site->code = $row["code"];
		$site->libelle = utf8_encode($row["libelle"]);
	}

	return $site;
}

function enregistrerUf(Unitefonctionnelle $uf, $maj = false)
{
	global $conn;
	$idUf = $uf->id;
	$code = $uf->code;
	$libelle = $uf->libelle;
	$servicefk = $uf->servicefk;

	$msg = "";
	if ($maj) {
		$msg = "mises";
		$query = "UPDATE unitefonctionnelles SET libelle='" . $libelle . "' WHERE code='" . $code . "'";		
	} else {
		$code = getServiceMaxId() . "_SRV_" . $servicefk;
		$msg = "enrégistrées";
		$query = "INSERT INTO unitefonctionnelles(code,libelle,servicefk)";
		$query .= " VALUES('" . $code . "', '" . $libelle . "'," . $servicefk . ")";
	}

	mysqli_set_charset($conn,'utf8');
	if (mysqli_query($conn, $query)) {
		$response[] = "Les informations de l'unité fonctionnelle ont été " . $msg . " avec succès.";
		if (!$maj) {
			$idUf = getUfMaxId();
		}		
	} else {
		$response[] = "Echec lors de la mise à jour de l'unité fonctionnelle." . mysqli_error($conn);
	}
	$response[] = $idUf;
	$response[] = $code;

	return $response;
}

function isUfExiste($libelle, $servicefk)
{
	global $conn;
	$queryById = "SELECT * FROM unitefonctionnelles where libelle = '" . $libelle . "'";
	$queryById .= " and servicefk='" . $servicefk . "'";
	if (mysqli_num_rows(mysqli_query($conn, $queryById)) > 0) {
		return 1;
	}

	return 0;
}
