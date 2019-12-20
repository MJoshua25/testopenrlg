<?php
	require_once "../db_connect.php";
	require_once '../professionnels.php';
	require_once '../../utils/personnes.utils.php';		
	echo getProfessionnelsJson(getTypeRole());
?>