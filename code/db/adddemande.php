<?php
    session_start();
    require_once "../db/db_connect.php";
    require_once '../models/demande.model.php';
    require_once "../db/demandes.php";

    $message_erreur = "";
    $professionnelfk = $_POST['professionnelfk'];
    $code = $_POST['code'];
    $date_contrat = $_POST['date_contrat'];
    $date_rendez_vous = $_POST['date_rendez_vous'];
    $heure_demande = $_POST['heure_demande'];
    $telephone = $_POST['telephone'];
    $intervention = $_POST['intervention'];
    $domaine = $_POST['domaine'];
    $duree = $_POST['duree'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $date_naissance = $_POST['date_naissance'];
    $langue = $_POST['langue'];
    $code_sexe = $_POST['code_sexe'];
    $pays_origine = $_POST['pays_origine'];
    $personnefk = $_POST['personnefk'];
    
    // professionnelfk
    if (empty($professionnelfk)) {
        $message_erreur = "Le professionnel de santé est obligatoire !!!";
    } else {
        // La date de demande        
        if(empty($date_contrat)){
            $message_erreur .= "La date de demande est obligatoire !!!";
        } else {
            // Date de rendez-vous
            if(empty($date_rendez_vous)){
                $message_erreur = "La date de rendez-vous est obligatoire !!!";
            } else {
                // heure de demande
                if(empty($heure_demande)){
                    $message_erreur = "L'heure de demande de rendez-vous est obligatoire !!!";
                } else {
                    // Format heure
                    if(count(explode(":",$heure_demande))==0){
                        $message_erreur = "L'heure de demande de rendez-vous est obligatoire !!!";
                    } else {
                        // Durée                        
                        if(empty($_POST['duree'])){
                            $message_erreur = "La durée est obligatoire !!!";
                        } else {
                            // telephone
                            if(empty($telephone)){
                                $message_erreur = "Le numéro de téléphone est obligatoire !!!";
                            } else {
                                // intervention
                                if(empty($intervention)){
                                    $message_erreur = "Le type d'intervention est obligatoire !!!";
                                } else {
                                    // domaine
                                    if(empty($domaine)){
                                        $message_erreur = "Le domaine est obligatoire !!!";
                                    } else {
                                        // Patient
                                        if(empty($nom)){
                                            // Nom
                                            $message_erreur = "Le nom du patient est obligatoire !!!";   
                                        } else {
                                            // prenom
                                            if(empty($prenom)){
                                                $message_erreur = "Le prenom du patient est obligatoire !!!";
                                            } else {
                                                // la date de naissance
                                                if(empty($date_naissance)){
                                                    $message_erreur = "La date de naissance du patient est obligatoire !!!";
                                                } else {
                                                    // Langue
                                                    if(empty($langue)){
                                                        $message_erreur = "La langue du patient est obligatoire !!!";
                                                    } else {
                                                        // Pays d'origine
                                                        if(empty($pays_origine)){
                                                            $message_erreur = "Le pays d'origine du patient est obligatoire !!!";
                                                        }                                                        
                                                    }
                                                }
                                            }
                                        }            
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    if(!empty($message_erreur)){
        $message_succes = $message_erreur;        
    } else {
        $heure_demande_explode = explode(":",$heure_demande);    
        $heure_rendez_vous = $heure_demande_explode[0];
        $minutes_rendez_vous = $heure_demande_explode[1];
        $patientfk = "";
        $demande = new Demande();
        $flag = false;
        if(isset($_POST['code']) && $_POST['code'] != "vide"){
            $flag = true;
            $demande->id = $_POST['code'];
            $code_user_to_update = $_SESSION['email'];        	
            $date_modif_enr = date("Y-m-d H:i:s"); 
        } else {
            $demande->code_user_to_create = $_SESSION['email'];	
            $demande->date_crea_enr	= date("Y-m-d H:i:s");     
        }      
        $demande->professionnelfk = $professionnelfk;
        $demande->date_demande = $date_contrat;
        $demande->date_rendez_vous = $date_rendez_vous;
        $demande->heure_rendez_vous = $heure_rendez_vous;        
        $demande->minutes_rendez_vous = $minutes_rendez_vous;
        $demande->duree = $_POST['duree'];
        $demande->intervention = $intervention;
        $demande->telephone = $intervention;        
        $demande->infos_complementaires = $_POST['infos_complementaires'];
        $demande->nom_patient = $nom;
        $demande->prenom_patient = $prenom;
        $demande->date_naissance_patient = $date_naissance;
        $demande->code_sexe_patient = $code_sexe;    
        $demande->pays_origine_patient = $pays_origine;
        $demande->langue_patient = $langue;
        $demande->patientfk = $_POST['patientfk'];
        $demande->domaine = $domaine;
        $message_succes = enregistrerDemande($demande, $flag);
    }
    echo $message_succes;
	exit;
?>