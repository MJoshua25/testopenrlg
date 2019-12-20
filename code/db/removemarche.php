<?php
	require_once "../db/db_connect.php";
	require_once "../db/marches.php";

	$id = $_POST['id'];
	
	if($id > 0){
		echo removeMarche($id);
		echo 1;		
		exit;
	}
	echo 0;
	exit;
?>