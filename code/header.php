<!DOCTYPE html>
<html lang="fr-FR">
<head>
    <meta charset="utf-8" />
	<title>Application OpenRLG</title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta content="" name="description" />
    <meta content="" name="author" />
    <link rel="stylesheet" href="../assets/css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/materialize.min.css">
    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="../assets/css/datatableplugin.css">       
    <link rel="stylesheet" href="../assets/js/dataTables/media/css/jquery.dataTables.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script type="text/javascript" language="javascript" src="../assets/js/dataTables/media/js/jquery.js"></script>
    <script language="JavaScript" type="text/javascript" src="../assets/js/materialize.min.js"></script>
    <script language="JavaScript" type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" language="javascript" src="../assets/js/dataTables/media/js/jquery.dataTables.js"></script>    
    <script language="JavaScript" type="text/javascript" src="../assets/js/main.js"></script>
</head>
<body role="document">
    <div>
        <div class="navbar-fixed">
            <nav>
                <div class="nav-wrapper #1565c0 blue darken-3">
                    <a href="../index.php" class="brand-logo">
                        <img src="../assets/img/logo_rlg.png" alt="Louis_Guilloux" class="logo_standard" />
                    </a>                                
                    <ul id="nav-mobile" class="right hide-on-med-and-down">                
                        <li>Application Louis Guilloux</li>
                        <li>&nbsp;&nbsp;</li>
                        <li>&nbsp;&nbsp;</li>
                        <li>&nbsp;&nbsp;</li>                        
                        <li><?php echo ucfirst($_SESSION['prenom']).' '.strtoupper($_SESSION['nom']); ?></li>
                        <li><a href="../logout.php">Déconnexion</a></li>
                    </ul>
                </div>
            </nav>           
        </div>
        <div class="page-header">
            <div class="row" style="text-align: center;color: #1565c0; font-weight: bold;">
                OPENRLG, L'application de gestion du système d'information du réseau Louis Guilloux
            </div>
        </div>
            
    
