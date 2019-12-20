<?php
    session_start();
    require_once "../db/db_connect.php";
    require_once '../models/langues.interprete.model.php';    
    require_once "../db/languesInterpretes.php";
    
    $message_erreur = "";
    // Type de contrat
    if(empty($_POST['langue'])){
        $message_erreur = "La langue est obligatoire !!!";
    } else {
        // Date de contrat
        if(empty($_POST['orale']) && empty($_POST['ecrite'])){
            $message_erreur = "Choississez au moins une langue orale ou écrite !!!";
        }
    }
    
    // S'il n'y pas de message d'erreur 
    if(!empty($message_erreur)){
        $message_succes = $message_erreur;
    } else {
        $langueInterprete = new LanguesInterprete();
        $flag = false;
        $orale = isset($_POST['orale'])?$_POST['orale']:0;      
        $ecrite = isset($_POST['ecrite'])?$_POST['ecrite']:0;        
        if(isset($_POST['codelngint'])){
            $flag = true;
            $langueInterprete->id = $_POST['codelngint'];
            $langueInterprete->code_user_to_update = $_SESSION['email'];
            $langueInterprete->date_modif_enr = date("Y-m-d H:i:s");
        } else {
            $langueInterprete->code_user_to_create = $_SESSION['email'];
            $langueInterprete->date_crea_enr	= date("Y-m-d H:i:s");  
        }
        if(isset($_POST['orale'])){
            $orale = 1;
        }
        if(isset($_POST['ecrite'])){
            $ecrite = 1; 
        }
        $langueInterprete->languefk = $_POST['langue'];
        $langueInterprete->langue_orale = $orale;
        $langueInterprete->langue_ecrite = $ecrite;
        $langueInterprete->interpretefk = $_POST['personnefk'];
        $resultat = enregistrerLanguesInterprete($langueInterprete, $flag,true);
        $message_succes = $resultat[0];
    }

    echo $message_succes;
	exit;
?>