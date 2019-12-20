<?php
	require_once "../db_connect.php";
	require_once '../interpretes.php';
	require_once '../../utils/personnes.utils.php';
	$typerole = getTypeRole();	
	echo getInterpretesJson($typerole);
?>