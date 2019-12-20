<?php
    function getTypeMarche(){
        $result = array();
        // MARCHE
        $result["MARCHE"] = "Marché";
        // CONVENTION
        $result["CONVENTION"] = "Convention public";
        
        return $result;
    }

    function getTypeLangue(){
        $result = array();
        // Ecrit
        $result["ECRITE"] = "Ecrite";
        // Ecrit-oral
        $result["ECRITE_ORALE"] = "Ecrite et Orale";
        // Oral
        $result["ORALE"] = "Orale";
        return $result;
    }
?>