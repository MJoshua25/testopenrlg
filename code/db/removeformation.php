<?php
	require_once "../db/db_connect.php";
	require_once "../db/formations.php";

	$id = $_POST['id'];
	
	if($id > 0){
		removeFormation($id);
		echo 1;
		exit;
	}
	echo 0;
	exit;
?>