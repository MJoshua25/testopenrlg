<?php
	require_once "../db/db_connect.php";
	require_once "../db/lotslangues.php";

	$id = $_POST['id'];
	
	if($id > 0){
		echo removeLotLangues($id);
		echo 1;		
		exit;
	}
	echo 0;
	exit;
?>