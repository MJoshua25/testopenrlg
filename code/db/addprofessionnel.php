<?php
    session_start();
    require_once "../db/db_connect.php";
    require_once '../models/professionnel.model.php';
    require_once '../utils/email.utils.php';
    require_once "../db/professionnels.php";
    require_once "../db/structures.php";
    require_once '../utils/structures.utils.php';

    $message_erreur = "";   
    $code = $_POST['code'];
  
    // Vérification des infos
    if (empty($_POST['civilite'])) {
        $message_erreur = "La civilité est obligatoire !!!";
    } else {
        // nom
        if(empty($_POST['civilite'])){
            $message_erreur = "Le nom est obligatoire !!!";            
        } else {
            // prenom
            if (empty($_POST['prenom'])) {
                $message_erreur = "Le prenom est obligatoire !!!";
            } else {
                // sexe
                if (empty($_POST['sexe'])) {
                    $message_erreur = "Le sexe est obligatoire !!!";
                } else {
                    if(empty($_POST['role'])){
                        $message_erreur = "Le role est obligatoire !!!";
                    }
                }
            }
        }
    }
    
    if(!empty($message_erreur)){
        $message_succes = $message_erreur;        
    } else {

        // S'il n'y pas de message d'erreur
        $idPsEnr = "";
        if (isset($_POST['code']) && $_POST['code'] != "vide") {
            $idPsEnr = $_POST['code'];
        }
        $actif = "";
        if(isset($_POST['actif']) && $_POST['actif'] == "on"){
            $actif = "1";
        }
        // Si RPFS ou RCAM
        if ($_POST['structurefk'] == "") {
            $message_erreur[] = "la structure";
        }
        $professionnel = getProfessionelsByInfos(
            $idPsEnr,
            $_POST['email'],
            $_POST['nom'],
            $_POST['prenom'],
            $_POST['civilite'],
            $_POST['sexe'],
            $_POST['role'],
            $actif,
            $_POST['structurefk'],
            $_POST['personnefk'],
            $_SESSION['email']
        );
        $flagEng = true;
        if ($code == 'vide') {
            $flagEng = false;
        }
        $response = enregistrerProfessionel($professionnel, $flagEng);
        $message_succes = $response[0];
    }

    echo $message_succes;
	exit;
?>