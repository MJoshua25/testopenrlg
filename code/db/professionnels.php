<?php	
	function getProfessionnels($typerole, $isPros=false){
		global $conn;
		$queryProfes = "SELECT professionnels.id as id, personne.email as email, personne.nom as nom,";
		$queryProfes .= " personne.prenom as prenom, personne.code_civilite as code_civilite,";
		$queryProfes .= " personne.code_sexe as code_sexe, personne.role as role";
		$queryProfes .= " FROM professionnels, personne where";
		$queryProfes .= " professionnels.personnefk = personne.id and";
		if($isPros){
			$queryProfes .= " personne.role = 'RPFS'";
		} else {
			$queryProfes .= " (personne.role = 'RPFS' OR personne.role = 'RPINT' OR personne.role = 'RCAM')";
		}
		$queryProfes .= " order by nom";

		$data = array();
		$resultProfes = mysqli_query($conn, $queryProfes);		
		while($row = mysqli_fetch_array($resultProfes))
		{
			$nestedData = array();
			$nestedData["id"] = $row["id"];
			$nestedData["email"] = $row["email"];
			$nestedData["nom"] = utf8_encode($row["nom"]);
			$nestedData["prenom"] = utf8_encode($row["prenom"]);
			$nestedData["code_civilite"] = utf8_encode($row["code_civilite"]);
			$nestedData["code_sexe"] = utf8_encode($row["code_sexe"]);			
			$nestedData["role"] = $typerole[$row["role"]];
			$data[] = $nestedData;			
		}
		
		return $data;
	}

	function getProfessionnelsJson($typerole){		
		$data = getProfessionnels($typerole);
		$json_data = array("data" => $data);			
		return json_encode($json_data,JSON_UNESCAPED_SLASHES);
	}

	function getProfessionnelByCode($code){
		global $conn;
		$queryProfesByCode = "SELECT professionnels.id as id, personne.email as email, personne.nom as nom,";
		$queryProfesByCode .= " personne.prenom as prenom, personne.code_civilite as code_civilite, ";
		$queryProfesByCode .= " professionnels.structurefk as structurefk,";
		$queryProfesByCode .= " personne.code_sexe as code_sexe, personne.role as role,";
		$queryProfesByCode .= " personne.token_activation as token_activation,";
		$queryProfesByCode .= " professionnels.personnefk as personnefk FROM professionnels,";		
		$queryProfesByCode .= " personne where professionnels.personnefk = personne.id and ";
		$queryProfesByCode .= " professionnels.id = ".$code." and (personne.role = 'RPFS'";
		$queryProfesByCode .= " OR personne.role = 'RPINT' OR personne.role = 'RCAM')";			

		$resultByCode = mysqli_query($conn, $queryProfesByCode);		
		$professionnel = new Professionnel();
		while($row = mysqli_fetch_array($resultByCode))
		{			
			$professionnel->id = $row["id"];
			$professionnel->email = $row["email"];
			$professionnel->nom = utf8_encode($row["nom"]);
			$professionnel->prenom = utf8_encode($row["prenom"]);							
			$professionnel->code_civilite = $row["code_civilite"];
			$professionnel->code_sexe = $row["code_sexe"];						
			$professionnel->role = $row["role"];
			$professionnel->token_activation = $row["token_activation"];		
			$professionnel->structurefk = $row["structurefk"];							
			$professionnel->personnefk = $row["personnefk"];							
		}
				
		return $professionnel;
	}

	function getProfessionelsByInfos($id, $email, $nom,$prenom,$code_civilite,$code_sexe,$role,$token_activation,$structurefk,$personnefk,$cu_created){		
		$professionnel = new Professionnel();
		$professionnel->id = $id;
		$professionnel->email = $email;
    	$professionnel->nom = $nom;
    	$professionnel->prenom = $prenom;
    	$professionnel->code_civilite = $code_civilite;
    	$professionnel->code_sexe = $code_sexe;
		$professionnel->role = $role;
		$professionnel->token_activation = $token_activation;
    	$professionnel->structurefk = $structurefk;    
		$professionnel->personnefk = $personnefk;
		$professionnel->code_user_to_create = $cu_created;
								
		return $professionnel;
	}

	function enregistrerProfessionel(Professionnel $professionel, $maj=false){
		global $conn;
		$response = array();
		$idPfs = $professionel->id;
		$email = $professionel->email;
		$nom = $professionel->nom;
		$prenom = $professionel->prenom;		
		$code_civilite = $professionel->code_civilite;
		$code_sexe = $professionel->code_sexe;
		$role = $professionel->role;
		$actif = $professionel->token_activation;		
		$structurefk = $professionel->structurefk;  
		$personnefk = $professionel->personnefk;
		$code_user_to_create = $professionel->code_user_to_create;	
		if($maj){
			$msg = "mises à jour";
			$queryEnregistrerProfesionnel = "UPDATE professionnels SET structurefk=".$structurefk." WHERE id=".$idPfs."";
			$resultat = mysqli_query($conn, $queryEnregistrerProfesionnel);
			
			$query = "UPDATE personne SET nom='".$nom."', prenom='".$prenom."',";
			$query .= "code_sexe='".$code_sexe."',code_civilite='".$code_civilite."',";		
			$query .= "email='".$email."',role='".$role."',	token_activation='".$actif."' ";
			$query .= " WHERE id=".$personnefk."";
			// utf8
			mysqli_set_charset($conn,'utf8');				
			mysqli_query($conn, $query);
		} else {
			// Création du code
			$msg = "enrégistrées";
			// Génerer un mode pas par défaut
			$mdpDefault = md5("openrlg2019");
			// Personne
			$queryEnregistrerPerso = "INSERT INTO personne(code_user_to_create,date_crea_enr,";
			$queryEnregistrerPerso .= "email,nom,prenom,code_civilite,";
			$queryEnregistrerPerso .= "code_sexe,role,token_activation,motdepasse,token_mdp) ";
			$queryEnregistrerPerso .= "VALUES('".$code_user_to_create."',";
			$queryEnregistrerPerso .= "'".date('Y-m-d h:i:s')."','".$email."', '".$nom."',";
			$queryEnregistrerPerso .= "'".$prenom."', '".$code_civilite."', '".$code_sexe."',";
			$queryEnregistrerPerso .= "'".$role."','".$actif."','".$mdpDefault."','')";
			// utf8
			mysqli_set_charset($conn,'utf8');
			mysqli_query($conn, $queryEnregistrerPerso);
			$persoFkresult = mysqli_insert_id($conn);

			if($structurefk != ""){
				$queryEnregistrerPs = "INSERT INTO professionnels(personnefk, structurefk) ";
				$queryEnregistrerPs .= " VALUES('".$persoFkresult."', '".$structurefk."')";		
				$resultat = mysqli_query($conn, $queryEnregistrerPs);
			} else {
				$resultat = true;
			}

			// Envoyer un email
			//envoyerMail($email);
		}
		
		$mgsEnr = "";
		if($resultat){
			$mgsEnr = 'Les informations du professionnel ont été '.$msg.' avec succès.';			
			if(!$maj){
				$idPfs = getMaxId();
			}			
		} else {
			$mgsEnr = 'Echec lors de la mise à jour du professionnel.'. mysqli_error($conn);
		}
		$response[] = $mgsEnr;
		$response[] = $idPfs;
			
		return $response;
	}

	function getPersonne($email,$nom,$prenom,$code_civilite,$code_sexe){
		$personne = new Personne();
		$personne->email = $email;
		$personne->nom = $nom;
		$personne->prenom = $prenom;
		$personne->code_civilite = $code_civilite;
		$personne->code_sexe = $code_sexe;
		
		return $personne;
	}
	
	function removeProfessionnel($id){
		global $conn;

		// Supprimer personne
		$queryProfessionnel = "DELETE FROM professionnels WHERE personnefk=".$id."";
		mysqli_query($conn,$queryProfessionnel);

		// Supprimer personne
		$queryPersonne = "DELETE FROM personne WHERE id=".$id."";
		mysqli_query($conn,$queryPersonne);
	}
?>