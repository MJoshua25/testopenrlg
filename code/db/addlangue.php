<?php
    require_once "../db/db_connect.php";
    require_once '../models/langue.model.php';
    require_once "../db/langues.php";

    $message_erreur = "";    
    $code = $_POST['code'];       
    
    // libelle de la structure
    if (empty($_POST['libelleLangue'])) {
        $message_erreur = "Le nom de la langue est obligatoire !!!";
    } else {
        // lot de langues
        if(empty($_POST['lotlanguefk'])){
            $message_erreur = "Le lot de langues est obligatoire !!!";
        }
    }

    if(!empty($message_erreur)){
        $message_succes = $message_erreur;        
    } else {
        // S'il n'y pas de message d'erreur
        $idLangueEnr = "";
        if (isset($_POST['idStruct']) && !empty($_POST['idStruct'])) {
            $idLangueEnr = $_POST['idStruct'];
        }
        $langue = getLangueByInfos(
            $idLangueEnr,
            $code,
            $_POST['libelleLangue'],            
            $_POST['lotlanguefk']
        );
        if (empty($message_erreur)) {
            $flagEng = true;
            if ($code == 'vide') {
                $flagEng = false;
            }
            $response = enregistrerLangue($langue, $flagEng);
            $message_succes = $response[0];            
        }
    }
     
    echo $message_succes;
	exit;
?>