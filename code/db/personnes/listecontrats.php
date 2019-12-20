<?php
	require_once "../db_connect.php";
	require_once '../contrats.php';
	require_once '../../utils/personnes.utils.php';	
	$typePeriodicite = getTypePeriodicite();
	$typeContrat = getTypeContrat();	
	echo getContratsJson($_GET['intprs'], $typeContrat,$typePeriodicite);
?>