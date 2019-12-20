<?php
    function getTypeOrganisme(){
        $result = array();
        // DEMANDEUR_PAYEUR
        $result["DEMANDEUR_PAYEUR"] = "Demandeur payeur";
        // DEMANDEUR
        $result["DEMANDEUR"] = "Demandeur";
        // PAYEUR
        $result["PAYEUR"] = "Payeur";

        return $result;
    }

    function getTypeStructure(){
        $result = array();

        //HOPITAUX
        $result["HOPITAUX"] = "Hôpital";
        //ASSOCIATIONS
        $result["ASSOCIATIONS"] = "Association";
        //COLLECTIVITES
        $result["COLLECTIVITES"] = "Collectivité";
        //MEDICO_SOCIAUX
        $result["MEDICO_SOCIAUX"] = "Centre médico-social";
        //AUTRES
        $result["AUTRES"] = "Autres";
        
        return $result;
    }
?>