<?php
    session_start();
    require_once "../db/db_connect.php";
    require_once '../models/formation.model.php';    
    require_once "../db/formations.php";
    
    $message_erreur = "";
    // Type de contrat
    if(empty($_POST['date_formation'])){
        $message_erreur = "La date de la formation est obligatoire";
    } else {
        // Date de contrat
        if(empty($_POST['sujet'])){
            $message_erreur = "Le sujet de la formation est obligatoire !!!";
        } else {
            // Nombre d'heures
            if(empty($_POST['type_formation'])){
                $message_erreur = "Le type de formation est obligatoire !!!";
            }
        }       
    }
    
    // S'il n'y pas de message d'erreur    
    if(!empty($message_erreur)){
        $message_succes = $message_erreur;        
    } else {
        $formation = new Formation();
        $flag = false;
        if(isset($_POST['codefrt'])){
            $flag = true;
            $formation->id = $_POST['codefrt'];
            $code_user_to_update = $_SESSION['email'];        	
            $date_modif_enr = date("Y-m-d H:i:s"); 
        } else {
            $formation->code_user_to_create = $_SESSION['email'];	
            $formation->date_crea_enr	= date("Y-m-d H:i:s");            
        }      
        $formation->date_formation = $_POST['date_formation'];
        $formation->sujet = $_POST['sujet'];
        $formation->type_formation = $_POST['type_formation'];
        $formation->analyse_formation = $_POST['analyse_formation'];        
        $formation->personnefk = $_POST['personnefk'];
        $message_succes = enregistrerFormation($formation, $flag);        
    } 

    echo $message_succes;
	exit;
?>