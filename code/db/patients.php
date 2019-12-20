<?php	
	
	function getPatientByCode($code){
		global $conn;
		$queryProfesByCode = "SELECT patients.id as id, personne.nom as nom,";
		$queryProfesByCode .= " personne.prenom as prenom, personne.date_naissance as date_naissance, ";
		$queryProfesByCode .= " personne.id as personnefk, patients.pays_origine as pays_origine,";
		$queryProfesByCode .= " patients.langue as langue, personne.code_sexe as code_sexe";
		$queryProfesByCode .= " FROM patients, personne where patients.personnefk = personne.id and";
		$queryProfesByCode .= " patients.id = ".$code."";

		$resultByCode = mysqli_query($conn, $queryProfesByCode);
		$patient = new Patient();
		while($row = mysqli_fetch_array($resultByCode))
		{
			$patient->id = $row["id"];
			$patient->prenom = $row["prenom"];
			$patient->nom = $row["nom"];
			$patient->date_naissance = $row["date_naissance"];
			$patient->code_sexe = $row["code_sexe"];
			$patient->personnefk = $row["personnefk"];
			$patient->pays_origine = $row["pays_origine"];
			$patient->langue = $row["langue"];
		}

		return $patient;
	}
?>