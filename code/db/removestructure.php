<?php
	require_once "../db/db_connect.php";
	require_once "../db/structures.php";

	$id = $_POST['id'];
	
	if($id > 0){
		echo removeStructure($id, true);
		echo 1;		
		exit;
	}
	echo 0;
	exit;
?>