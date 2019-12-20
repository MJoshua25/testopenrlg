<?php
	session_start();
	if (!isset($_SESSION['isLogin']) || (isset($_SESSION['isLogin']) && $_SESSION['isLogin'] != "isOk")) {		
		header("Location: ../login.php");
		exit;
	}
	
	require_once "../header.php";
	if(isset($_GET['code']) && isset($_GET['tpprs'])){
		if($_GET['tpprs'] == "int"){
			if(isset($_GET['crt'])){
				require_once "interpretes/forms_contrat.php";
			} else if(isset($_GET['frt'])){
				require_once "interpretes/forms_formation.php";
			} else if(isset($_GET['lngint'])){
				require_once "interpretes/forms_langue_interp.php";
			} else {
				require_once "forms_interpretes.php";
			}			
		} else {			
			require_once "forms_professionnels.php";
		}		
	} else {
		require_once "tabspersonnes.php";
	}	
	//require_once "../footer.php";	
?>