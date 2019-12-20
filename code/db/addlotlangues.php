<?php
    require_once "../db/db_connect.php";
    require_once '../models/lotlangues.model.php';
    require_once "../db/lotslangues.php";
    require_once '../db/marches.php';

    $message_erreur = "";    
    $code = $_POST['code'];       
    
    // libelle de la structure
    if (empty($_POST['libelleLotLangues'])) {
        $message_erreur = "Le nom du lot langues est obligatoire !!!";
    } else {
        // marcheconvention
        if(empty($_POST['marcheconvention'])){
            $message_erreur = "Le marché / convention est obligatoire !!!";
        }
    }

    if(!empty($message_erreur)){
        $message_succes = $message_erreur;        
    } else {
        // S'il n'y pas de message d'erreur
        $idLotlanguesEnr = "";
        if (isset($_POST['idLotlangues']) && !empty($_POST['idLotlangues'])) {
            $idLotlanguesEnr = $_POST['idLotlangues'];
        }
        $lotlangues = getLotLanguesByInfos(
            $idLotlanguesEnr,
            $code,
            $_POST['libelleLotLangues'],
            $_POST['marcheconvention']
        );
        if (empty($message_erreur)) {
            $flagEng = true;
            if ($code == 'vide') {
                $flagEng = false;
            }
            $response = enregistrerLotLangues($lotlangues, $flagEng);
            $message_succes = $response[0];           
        }
    }
     
    echo $message_succes;
	exit;
?>