<?php
function getTypeRole()
{
    $result = array();
    // RPFS
    $result["RPFS"] = "Professionnel";
    // RPINT
    $result["RPINT"] = "Pole interpretariat";
    // RCAM
    $result["RCAM"] = "Pole cabinet medical";
    // RINT
    $result["RINT"] = "Interpretre";
    // ADMIN
    $result["ADMIN"] = "Admin";

    return $result;
}

function getTypeContrat()
{
    $result = array();
    // CDD
    $result["CDD"] = "CDD";    
    // CDD_MIS
    $result["CDD_MIS"] = "CDD a la mission";
    // CDD_ATP
    $result["CDD_ATP"] = "CDD avec terme precis amenage";
    // CDI
    $result["CDI"] = "CDI";
    

    return $result;
}

function getTypePeriodicite()
{
    $result = array();
    // CONTRAT
    $result["CONTRAT"] = "contrat";
    // AN
    $result["AN"] = "an";
    // MOIS
    $result["MOIS"] = "mois";
    
    return $result;
}

function getTypeFormation()
{
    $result = array();
    // FORMATION
    $result["FORM"] = "Formation";
    // DEMANDE DE FORMATION
    $result["DEM_FORM"] = "Demande de formation";
        
    return $result;
}
