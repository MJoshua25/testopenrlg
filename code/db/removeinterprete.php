<?php
	require_once "../db/db_connect.php";
	require_once "../db/interpretes.php";

	$id = $_POST['id'];
	
	if($id > 0){
		removeInterprete($id);
		echo 1;
		exit;
	}
	echo 0;
	exit;
?>