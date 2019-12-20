<?php
	require_once "../db_connect.php";
	require_once '../structures.php';
	require_once '../../utils/structures.utils.php';
	$typeorganisme = getTypeOrganisme();
	$typestructure = getTypeStructure();
	echo getStructuresJson($typeorganisme,$typestructure);
?>