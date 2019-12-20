<?php
	session_start();
	if (!isset($_SESSION['isLogin']) || (isset($_SESSION['isLogin']) && $_SESSION['isLogin'] != "isOk")) {		
		header("Location: ../login.php");
		exit;
	}
	require_once "../header.php";
	if(isset($_GET['code']) && isset($_GET['tplgm'])){
		if($_GET['tplgm'] == "mrc"){			
			require_once "forms_marches.php";
		} else if($_GET['tplgm'] == "ltlgn"){			
			require_once "forms_lotslangues.php";
		} else {			
			require_once "forms_langues.php";
		}		
	} else {
		require_once "tabslangues.php";
	}	
	//require_once "../footer.php";	
?>