<?php
class Demande
{
    public $id;
    public $code_user_to_create;
    public $code_user_to_update;
    public $date_crea_enr;
    public $date_modif_enr;
    public $professionnelfk;
    public $date_demande;
    public $date_rendez_vous;
    public $heure_rendez_vous;
    public $minutes_rendez_vous;
    public $duree;
    public $intervention;
    public $telephone;
    public $adressefk;
    public $domaine;
    public $infos_complementaires;
    public $nom_patient;
    public $prenom_patient;
    public $date_naissance_patient;
    public $code_sexe_patient;    
    public $pays_origine_patient;
    public $langue_patient;    
    public $patientfk;
    public $personnefk;
}