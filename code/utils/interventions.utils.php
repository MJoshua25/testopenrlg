<?php
    function getTypeIntervention(){
        $result = array();
        // EN_COURS
        $result["EN_COURS"] = "En cours";
        // EN_ATTENTE
        $result["EN_ATTENTE"] = "En attente";
        // VALIDE
        $result["VALIDE"] = "Validé";
        
        return $result;
    }
?>