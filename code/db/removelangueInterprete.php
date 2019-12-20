<?php
	require_once "../db/db_connect.php";
	require_once "../db/languesInterpretes.php";

	$id = $_POST['id'];
	$personnefk = $_POST['personnefk'];
	$languefk = $_POST['languefk'];
	
	if($id > 0){
		removeLanguesInterprete($personnefk,$languefk);
		echo 1;		
		exit;
	}
	echo 0;
	exit;
?>