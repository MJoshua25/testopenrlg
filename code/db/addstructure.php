<?php
    require_once "../db/db_connect.php";
    require_once '../models/structure.model.php';
    require_once '../models/site.model.php';
    require_once '../models/service.model.php';
    require_once '../models/unitefonctionnelle.model.php';
    require_once "../db/structures.php";
    require_once "../db/sites.php";
    require_once "../db/services.php";
    require_once "../db/unitefonctionnelles.php";

    $message_erreur = "";    
    $code = $_POST['code'];
    
    // libelle de la structure
    if (empty($_POST['libelleStruct'])) {
        $message_erreur = "Le nom de l'organisme est obligatoire !!!";
    } else {
        // typeorganisme
        if(empty($_POST['typeorganisme'])){
            $message_erreur = "Le type d'organisme est obligatoire !!!";
        } else {
            // type de structure
            if (empty($_POST['typestructure'])) {
                $message_erreur = "Le type de structure est obligatoire !!!";
            } else {
                if(empty($_POST['adresse'])){
                    $message_erreur = "L'adresse est obligatoire !!!";
                } else {
                    if(empty($_POST['codepostal'])){
                        $message_erreur = "Le code postal est obligatoire !!!";
                    } else {
                        if(empty($_POST['ville'])){
                            $message_erreur = "La localité est obligatoire !!!";
                        }
                    }
                }
            }
        }
    }

    if(!empty($message_erreur)){
        $message_succes = $message_erreur;        
    } else {
        // S'il n'y pas de message d'erreur
        $idStructEnr = "";
        if (isset($_POST['idStruct']) && !empty($_POST['idStruct'])) {
            $idStructEnr = $_POST['idStruct'];
        }
        $structure = getStructureByInfos(
            $idStructEnr,
            $code,
            $_POST['libelleStruct'],
            $_POST['typeorganisme'],
            $_POST['typestructure'],
            $_POST['adresse'],
            $_POST['adresse2'],
            $_POST['codepostal'],
            $_POST['email'],
            $_POST['telephone'],
            $_POST['fax'],
            $_POST['ville']
        );
        if (empty($message_erreur)) {
            $flagEng = true;
            if ($code == 'vide') {
                $flagEng = false;
            }
            $response = enregistrerStructure($structure, $flagEng);
            $message_succes = $response[0];            
        }
    }  
          
    echo $message_succes;
	exit;
?>