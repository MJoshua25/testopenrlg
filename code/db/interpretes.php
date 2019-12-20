<?php
	function getInterpretes($typerole)
	{
		global $conn;
		$queryInterps = "SELECT interpretes.id as id, personne.email as email, personne.nom as nom,";
		$queryInterps .= " personne.prenom as prenom, personne.code_civilite as code_civilite,";
		$queryInterps .= " personne.code_sexe as code_sexe, personne.role as role,";
		$queryInterps .= " interpretes.personnefk as personnefk";
		$queryInterps .= " FROM interpretes, personne where interpretes.personnefk = personne.id";
		$queryInterps .= " and personne.role = 'RINT'";		
		$data = array();
		$resultInterps = mysqli_query($conn, $queryInterps);		
		while($row = mysqli_fetch_array($resultInterps))
		{
			$nestedData = array();
			$nestedData["id"] = $row["id"];
			$nestedData["email"] = $row["email"];
			$nestedData["nom"] = utf8_encode($row["nom"]);
			$nestedData["prenom"] = utf8_encode($row["prenom"]);
			$nestedData["code_civilite"] = utf8_encode($row["code_civilite"]);
			$nestedData["code_sexe"] = utf8_encode($row["code_sexe"]);			
			$nestedData["role"] = $typerole[$row["role"]];
			$nestedData["personnefk"] = $row["personnefk"];
			$data[] = $nestedData;
		}		
				
		return $data;
	}

	function getInterpretesJson($typerole)	
	{		
		$json_data = array("data" => getInterpretes($typerole));
		return json_encode($json_data, JSON_UNESCAPED_SLASHES);
	}

	function getInterpreteByCode($code)
	{
		global $conn;
		$queryInterpByCode = "SELECT interpretes.id as id, personne.email as email, ";
		$queryInterpByCode .= " personne.nom as nom_naissance, personne.prenom as prenom,";
		$queryInterpByCode .= " personne.code_civilite as code_civilite, ";		
		$queryInterpByCode .= " personne.code_sexe as code_sexe, ";
		$queryInterpByCode .= " interpretes.date_naissance as date_naissance, ";
		$queryInterpByCode .= " interpretes.date_debut as date_debut,";
		$queryInterpByCode .= " interpretes.date_fin as date_fin,";
		$queryInterpByCode .= " interpretes.adresse as adresse, interpretes.ville as ville,";		
		$queryInterpByCode .= " interpretes.code_postal as code_postal, ";
		$queryInterpByCode .= " interpretes.code_postal as num_sec_sociale, ";
		$queryInterpByCode .= " interpretes.diplome as diplome,";
		$queryInterpByCode .= " interpretes.permis_vehicule as permis_vehicule,";
		$queryInterpByCode .= " interpretes.ch_fisc_vehicule as ch_fisc_vehicule,";
		$queryInterpByCode .= " interpretes.tel_pro as tel_pro,";
		$queryInterpByCode .= " interpretes.tel_perso as tel_perso,";
		$queryInterpByCode .= " interpretes.personnefk as personnefk FROM interpretes,";		
		$queryInterpByCode .= " personne where interpretes.personnefk = personne.id and ";
		$queryInterpByCode .= " interpretes.id = ".$code." and personne.role = 'RINT'";
		
		$resultByCode = mysqli_query($conn, $queryInterpByCode);		
		$interprete = new Interprete();
		while($row = mysqli_fetch_array($resultByCode))
		{			
			$interprete->id = $row["id"];
			$interprete->email = $row["email"];
			$interprete->nom_naissance = utf8_encode($row["nom_naissance"]);
			$interprete->prenoms = utf8_encode($row["prenom"]);
			$interprete->code_civilite = $row["code_civilite"];
			$interprete->code_sexe = $row["code_sexe"];
			$interprete->date_naissance = $row["date_naissance"];
			$interprete->date_debut = $row["date_debut"];
			$interprete->date_fin = $row["date_fin"];
			$interprete->adresse = $row["adresse"];
			$interprete->ville = $row["ville"];
			$interprete->code_postal = $row["code_postal"];
			$interprete->diplome = $row["diplome"];
			$interprete->num_sec_sociale = $row["num_sec_sociale"];
			$interprete->permis_vehicule = $row["permis_vehicule"];
			$interprete->ch_fisc_vehicule = $row["ch_fisc_vehicule"];
			$interprete->tel_pro = $row["tel_pro"];
			$interprete->tel_perso = $row["tel_perso"];
			$interprete->personnefk = $row["personnefk"];			
		}

		return $interprete;
	}

	function enregistrerInterprete(Interprete $interprete, $maj=false){
		global $conn;

		$response = array();
		$msg = "";
		// utf8
		mysqli_set_charset($conn,'utf8');
		if(!$maj){
			// Données interprète
			$msg = "mises";

			// Partie interprète
			$queryEnregistrerInterprete = "UPDATE interpretes SET ";
			$queryEnregistrerInterprete .= "nom_marital='".$interprete->nom_marital."',";
			$queryEnregistrerInterprete .= "date_naissance='".$interprete->date_naissance."',";
			$queryEnregistrerInterprete .= "date_debut='".$interprete->date_debut."',";
			$queryEnregistrerInterprete .= "date_fin='".$interprete->date_fin."',";
			$queryEnregistrerInterprete .= "adresse='".$interprete->adresse."',";
			$queryEnregistrerInterprete .= "ville='".$interprete->ville."',";
			$queryEnregistrerInterprete .= "code_postal='".$interprete->code_postal."',";
			$queryEnregistrerInterprete .= "is_actif='".$interprete->is_actif."',";
			$queryEnregistrerInterprete .= "diplome='".$interprete->diplome."',";
			$queryEnregistrerInterprete .= "num_sec_sociale='".$interprete->num_sec_sociale."',";
			$queryEnregistrerInterprete .= "permis_vehicule='".$interprete->permis_vehicule."',";
			$queryEnregistrerInterprete .= "ch_fisc_vehicule='".$interprete->ch_fisc_vehicule."',";
			$queryEnregistrerInterprete .= "tel_perso='".$interprete->tel_perso."',";
			$queryEnregistrerInterprete .= "tel_pro='".$interprete->tel_pro."'";
			$queryEnregistrerInterprete .= " WHERE id='".$interprete->id."'";			
			$resultat = mysqli_query($conn, $queryEnregistrerInterprete);

			// Partie personne
			$queryEnregistrerPerso = "UPDATE personne SET nom='".$interprete->nom_naissance."',";
			$queryEnregistrerPerso .= "prenom='".$interprete->prenoms."',";
			$queryEnregistrerPerso .= "code_sexe='".$interprete->code_sexe."',";
			$queryEnregistrerPerso .= "code_civilite='".$interprete->code_civilite."',";
			$queryEnregistrerPerso .= "email='".$interprete->email."'";
			$queryEnregistrerPerso .= " WHERE id=".$interprete->personnefk."";
			mysqli_query($conn, $queryEnregistrerPerso);
		} else {
			// Création	
			$msg = "enrégistrées";
			
			// Personne
			$queryEnregistrerPerso = "INSERT INTO personne(code_user_to_create,date_crea_enr,";
			$queryEnregistrerPerso .= "email,nom,prenom,code_civilite,";
			$queryEnregistrerPerso .= "code_sexe,role) VALUES('".$_SESSION['email']."',";
			$queryEnregistrerPerso .= "'".date('Y-m-d h:i:s')."','".$interprete->email."',";
			$queryEnregistrerPerso .= "'".$interprete->nom_naissance."','".$interprete->prenoms."',";			 			
			$queryEnregistrerPerso .= "'".$interprete->code_civilite."','".$interprete->code_sexe."',";
			$queryEnregistrerPerso .= "'RINT')";
			mysqli_query($conn, $queryEnregistrerPerso);			
			$persoFkresult = mysqli_insert_id($conn);

			$queryEnregistrerInterprete = "INSERT INTO interpretes(nom_marital,date_naissance,";
			$queryEnregistrerInterprete .= "date_debut,date_fin,adresse,ville,code_postal,is_actif,";
			$queryEnregistrerInterprete .= "diplome,num_sec_sociale,permis_vehicule,ch_fisc_vehicule,";
			$queryEnregistrerInterprete .= "tel_perso,tel_pro,personnefk)";
			$queryEnregistrerInterprete .= " VALUES('".$interprete->nom_marital."',";
			$queryEnregistrerInterprete .= "'".$interprete->date_naissance."',";
			$queryEnregistrerInterprete .= "'".$interprete->date_debut."',";
			$queryEnregistrerInterprete .= "'".$interprete->date_fin."',";
			$queryEnregistrerInterprete .= "'".$interprete->adresse."',";
			$queryEnregistrerInterprete .= "'".$interprete->ville."',";
			$queryEnregistrerInterprete .= "'".$interprete->code_postal."',";
			$queryEnregistrerInterprete .= "'".$interprete->is_actif."',";
			$queryEnregistrerInterprete .= "'".$interprete->diplome."',";
			$queryEnregistrerInterprete .= "'".$interprete->num_sec_sociale."',";
			$queryEnregistrerInterprete .= "'".$interprete->permis_vehicule."',";
			$queryEnregistrerInterprete .= "'".$interprete->ch_fisc_vehicule."',";
			$queryEnregistrerInterprete .= "'".$interprete->tel_perso."',";
			$queryEnregistrerInterprete .= "'".$interprete->tel_pro."','".$persoFkresult."')";
			$resultat = mysqli_query($conn, $queryEnregistrerInterprete);			
			$persoIntResult = mysqli_insert_id($conn);
		}

		if($resultat){			
			$response[] = "Les informations de l'interprète ont été ".$msg." avec succès.";
			if($maj){				
				$response[] = $persoIntResult;
			}						
		} else{
			$response[] = "Echec lors de la mise à jour de l'interprète.".mysqli_error($conn);
		}
		return $response;
	}
	
	function getInterpreteByInfos($id,$email,$nom_naissance,$nom_marital,$prenoms,$code_civilite,
	$code_sexe,$is_actif,$date_naissance,$date_debut,$date_fin,$adresse,$ville,$code_postal,
	$diplome,$num_sec_sociale,$permis_vehicule,$ch_fisc_vehicule,$tel_pro,$personnefk)
	{		
		$interprete = new Interprete();
		$interprete->id = $id;
		$interprete->email = $email;
		$interprete->nom_naissance = $nom_naissance;    
		$interprete->nom_marital = $nom_marital;
		$interprete->prenoms = $prenoms;
		$interprete->code_civilite = $code_civilite;
		$interprete->code_sexe = $code_sexe;
		$interprete->is_actif = $is_actif;
		$interprete->date_naissance = $date_naissance;
		$interprete->date_debut = $date_debut;
		$interprete->date_fin = $date_fin;
		$interprete->adresse = $adresse;
		$interprete->ville = $ville;
		$interprete->code_postal = $code_postal;
		$interprete->diplome = $diplome;
		$interprete->num_sec_sociale = $num_sec_sociale;
		$interprete->permis_vehicule = $permis_vehicule;
		$interprete->ch_fisc_vehicule = $ch_fisc_vehicule;
		$interprete->tel_pro = $tel_pro;
		$interprete->tel_pro = $tel_pro;
		$interprete->personnefk = $personnefk;
		
		return $interprete;
	}

	function removeInterprete($id)
	{
		global $conn;

		// Supprimer personne
		$queryInterprete = "DELETE FROM interpretes WHERE personnefk=".$id."";
		mysqli_query($conn,$queryInterprete);

		// Supprimer personne
		$queryPersonne = "DELETE FROM personne WHERE id=".$id."";
		mysqli_query($conn,$queryPersonne);
	}
?>