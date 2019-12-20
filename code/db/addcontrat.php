<?php
    session_start();
    require_once "../db/db_connect.php";
    require_once '../models/contrat.model.php';    
    require_once "../db/contrats.php";
    
    $message_erreur = "";
    // Type de contrat
    if(empty($_POST['typecontrat'])){
        $message_erreur = "Le type de contrat est obligatoire";
    } else {
        // Date de contrat
        if(empty($_POST['date_contrat'])){
            $message_erreur = "La date du contrat est obligatoire !!!";
        } else {
            // Nombre d'heures
            if(empty($_POST['nb_heures'])){
                $message_erreur = "Le nombre d'heures du contrat est obligatoire !!!";
            } else {
                // Périodicité
                if(empty($_POST['type_periodicite'])){
                    $message_erreur = "La périodicité du contrat est obligatoire !!!";
                }          
            }
        }       
    }
    
    // S'il n'y pas de message d'erreur    
    if(!empty($message_erreur)){
        $message_succes = $message_erreur;        
    } else {
        $contrat = new Contrat();
        $flag = false;
        if(isset($_POST['codecrt'])){
            $flag = true;
            $contrat->id = $_POST['codecrt'];
            $code_user_to_update = $_SESSION['email'];        	
            $date_modif_enr = date("Y-m-d H:i:s"); 
        } else {
            $contrat->code_user_to_create = $_SESSION['email'];	
            $contrat->date_crea_enr	= date("Y-m-d H:i:s");            
        }              
        $contrat->date_contrat = $_POST['date_contrat'];
        $contrat->nb_heures = $_POST['nb_heures'];
        $contrat->periodicite = $_POST['type_periodicite'];
        $contrat->typecontrat = $_POST['typecontrat'];
        $contrat->date_medecin_travail = $_POST['date_medecin_travail'];
        $contrat->date_entretien = $_POST['entretien_individuel'];
        $contrat->entretien_stagiaire = $_POST['entretien_stagiaire'];
        $contrat->personnefk = $_POST['personnefk'];

        enregistrerContrat($contrat, $flag);
        $message_succes = "Les données ont été enregistrées avec succès !!!";
    } 

    echo $message_succes;
	exit;
?>