<?php
	require_once "../db_connect.php";
	require_once '../marches.php';
	require_once '../../utils/langues.utils.php';
	$typemarche = getTypeMarche();	
	echo getMarchesJson($typemarche);
?>