<?php
session_start();
require_once "../db/db_connect.php";
require_once '../models/interprete.model.php';
require_once "../db/interpretes.php";
require_once '../models/personne.model.php';
require_once "../db/personne.php";

$message_erreur = "";
// Type de contrat
if (empty($_POST['code_civilite'])) {
    $message_erreur = "Le code civilité est obligatoire";
} else {
    // Date de contrat
    if (empty($_POST['code_sexe'])) {
        $message_erreur = "Le code sexe est obligatoire !!!";
    } else {
        // Nombre d'heures
        if (empty($_POST['nom_naissance'])) {
            $message_erreur = "Le nom de naissance est obligatoire !!!";
        } else {
            // Périodicité
            if (empty($_POST['prenom'])) {
                $message_erreur = "Le prenom est obligatoire !!!";
            } else {
                // Date de naissance
                if (empty($_POST['date_naissance'])) {
                    $message_erreur = "La date de naissance est obligatoire !!!";
                } else {
                    // Adresse email
                    if (empty($_POST['email'])) {
                        $message_erreur = "L'adresse email est obligatoire !!!";
                    }
                }
            }
        }
    }
}

$idInterprete = $_POST['idInterprete'];

// S'il n'y pas de message d'erreur
$idIntEnr = "";
$interprete = new Interprete();
$personne = new Personne();
// Création d'Interprètre
$interprete = getInterpreteByInfos(
    $idIntEnr,
    $_POST['email'],
    $_POST['nom_naissance'],
    $_POST['nom_marital'],
    $_POST['prenom'],
    $_POST['code_civilite'],
    $_POST['code_sexe'],
    $_POST['is_actif'],
    $_POST['date_naissance'],
    $_POST['date_debut'],
    $_POST['date_fin'],
    $_POST['adresse'],
    $_POST['ville'],
    $_POST['code_postal'],
    $_POST['diplome'],
    $_POST['num_sec_sociale'],
    $_POST['permis_vehicule'],
    $_POST['ch_fisc_vehicule'],
    $_POST['tel_pro'],
    $_POST['personnefk']
);

if (isset($_POST['idInterprete']) && !empty($_POST['idInterprete'])) {
    // Interprete
    $idIntEnr = $_POST['idInterprete'];

    $is_actif =$_POST['is_actif'];
    if($is_actif == "2"){
        $is_actif = "";
    }

    // Création de personne
    $personne = getPersonneByEmail($_POST['email']);

    // Langues interpretes
    $listeLangInt = array();

    // Documents    
} else {
    // personne
    $personne = getPersonneByInfos(
        $_POST['personnefk'],
        $_POST['email'],
        $_POST['nom_naissance'],
        $_POST['prenom'],
        date("Y-m-d"),
        $_SESSION['email'],
        $_POST['code_civilite'],
        $_POST['code_sexe']
    );
}

if (empty($message_erreur)) {
    $flagEng = true;
    if ($idInterprete != 'vide') {
        $flagEng = false;
    }
    // Interprete
    $respInt = enregistrerInterprete($interprete, $flagEng);
    // Langue_Interprete
    $message_succes = $respInt[0];
} else {
    $message_succes = $message_erreur;
}

echo $message_succes;
exit;
