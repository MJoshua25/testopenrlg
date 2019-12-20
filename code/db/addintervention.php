<?php
    session_start();
    require_once "../db/db_connect.php";
    require_once '../models/intervention.model.php';
    require_once "../db/interventions.php";

    $message_erreur = "";
    $interpretefk = $_GET['interpretefk'];
    $structurefk = $_POST['structurefk'];
    $demandefk = $_POST['demandefk'];    
    $nb_usagers = 1;
    $heure_arrivee = $_POST['heure_arrivee'];
    $heure_depart = $_POST['heure_depart'];    
    $duree = $_POST['duree'];
    $etat = $_POST['etat'];
    $indisponibilite = "0";
    
    if(isset($_POST['indisponibilite'])){
        $indisponibilite = $_POST['indisponibilite'];
    }
    $signature = "0";
    if(isset($_POST['signature']) && $_POST['signature'] == 'on'){
        $signature = '1';
    }

    // Structure
    if(empty($structurefk)){
        $message_erreur = "Le lieu du rendez-vous est obligatoire !!!";
    } else {
        if (empty($_POST['demandefk'])) {
            $message_erreur = "La demande est obligatoire !!!";
        } else {
            // interpretefk
            if (empty($interpretefk)) {
                $message_erreur = "L'interprète est obligatoire !!!";
            } else {
                // Heure d'arrivée
                if(empty($heure_arrivee)){
                    $message_erreur = "L'heure d'arrivée est obligatoire !!!";
                } else {
                    // Format heure d'arrivée
                    if(count(explode(":",$heure_arrivee))==0){
                        $message_erreur = "L'heure d'arrivée n'est pas au format hh:mm !!!";
                    } else {
                        // heure_depart
                        if(empty($heure_depart)){
                            $message_erreur = "L'heure de depart est obligatoire !!!";
                        } else {
                            if(count(explode(":",$heure_depart))==0){
                                $message_erreur = "L'heure de depart n'est pas au format hh:mm !!!";
                            } else {
                                // La durée est obligatoire
                                if(empty($duree)){
                                    $message_erreur = "La durée est obligatoire !!!";
                                }
                            }
                        }
                    }
                }               
            }
        }   
    }

    if (!empty($message_erreur)) {
        $message_succes = $message_erreur;
    } else {
        // Enregistrer
        $intervention = new Intervention();
        $flag = false;
        if(isset($_POST['code']) && $_POST['code'] != "vide"){
            $flag = true;
            $intervention->id = $_POST['code'];
            $code_user_to_update = $_SESSION['email'];        	
            $date_modif_enr = date("Y-m-d H:i:s"); 
        } else {
            $intervention->code_user_to_create = $_SESSION['email'];	
            $intervention->date_crea_enr	= date("Y-m-d H:i:s");    
        }        
        $intervention->lieurdvfk = $structurefk;
        $intervention->interpretefk = $interpretefk;
        $intervention->demandefk = $demandefk;    
        $intervention->nb_usagers = $nb_usagers;
        // heure_arrivee
        $heure_arrivee_expl = explode(":",$heure_arrivee);
        $intervention->heure_arrivee = $heure_arrivee_expl[0];
        $intervention->minutes_arrivee = $heure_arrivee_expl[1];
        // heure_depart
        $heure_depart_expl = explode(":",$heure_depart);
        $intervention->heure_depart = $heure_depart_expl[0];
        $intervention->minutes_depart = $heure_depart_expl[1];
        $intervention->duree = $duree;
        $intervention->etat = $etat;
        $intervention->indisponibilite = $indisponibilite;
        $intervention->signature = $signature;     
        $message_succes = enregistrerIntervention($intervention, $flag);
    }

    echo $message_succes;
    exit;
