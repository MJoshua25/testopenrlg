<?php
    require_once "../db/db_connect.php";    
    require_once '../models/marche.model.php';
    require_once "../db/marches.php";
    
    $message_erreur = "";    
    $code = $_POST['code'];       
   
    // numerocontrat
    if (empty($_POST['numerocontrat'])) {
        $message_erreur = "Le numéro de contrat est obligatoire !!!";
    } else {
        // nomcontrat
        if(empty($_POST['nomcontrat'])){
            $message_erreur = "Le nom du contrat est obligatoire !!!";
        } else {
            if(empty($_POST['typecontrat'])){
                $message_erreur = "Le type de contrat est obligatoire !!!";
            } else {
                if(empty($_POST['prix'])){
                    $message_erreur = "Le prix de contrat est obligatoire !!!";
                }
            }
        }
    }

    if(!empty($message_erreur)){
        $message_succes = $message_erreur;        
    } else {
        // S'il n'y pas de message d'erreur
        $idMarcheEnr = "";
        if (isset($_POST['idMarche']) && !empty($_POST['idMarche'])) {
            $idMarcheEnr = $_POST['idMarche'];
        }        
        $marche = getMarcheByInfos(
            $idMarcheEnr,
            $_POST['numerocontrat'],
            $_POST['nomcontrat'],
            $_POST['typecontrat'],
            $_POST['prix'],
            $_POST['date_debut'],
            $_POST['date_fin']
        );        
        $flagEng = true;
        if (empty($idMarcheEnr)) {
            $flagEng = false;
        }            
        $response = enregistrerMarche($marche, $flagEng);
        $message_succes = $response[0];
    }
     
    echo $message_succes;
	exit;
?>