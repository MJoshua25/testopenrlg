<?php
	session_start();
	if (!isset($_SESSION['isLogin']) || (isset($_SESSION['isLogin']) && $_SESSION['isLogin'] != "isOk")) {		
		header("Location: ../login.php");
		exit;
	}
	require_once "../header.php";
	if(isset($_GET['code']) && !isset($_GET['codeSite'])){		
		require_once "forms.php";
	} else if(isset($_GET['code']) && isset($_GET['codeSite'])){		
		require_once "forms_sites.php";
	} else {
		require_once "structures.php";
	}
	//require_once "../footer.php";	
?>