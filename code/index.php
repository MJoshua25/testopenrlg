<?php
session_start();
if (!isset($_SESSION['isLogin']) || (isset($_SESSION['isLogin']) && $_SESSION['isLogin'] != "isOk")) {    
    header("Location: login.php");
    exit;
}
if(isset($_SESSION['isLogin']) && isset($_SESSION['token_mdp']) && 
    empty($_SESSION['token_mdp'])){
    header("Location: initmdp.php");
    exit;
}
$isAccess = ($_SESSION['role']=="ADMIN" || $_SESSION['role']=="RPINT");
?>
<!DOCTYPE html>
<html lang="fr-FR">

<head>
    <meta charset="UTF-8">
    <title>Accueil</title>
    <link rel="stylesheet" href="assets/css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/materialize.min.css">
    <script type="text/javascript" language="javascript" src="assets/js/dataTables/media/js/jquery.js"></script>
    <script language="JavaScript" type="text/javascript" src="assets/js/materialize.min.js"></script>
    <script language="JavaScript" type="text/javascript" src="assets/js/main.js"></script>
    <style>
        .ayo:hover {
            box-shadow: 0 0 7px 4px rgba(0, 0, 0, 0.4);
            color: purple;
            border-radius: 1px;
            font-size: 15px;
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
</head>

<body role="document">
    <div>
        <nav>
            <div class="nav-wrapper #1565c0 blue darken-3">
                <a href="index.php" class="brand-logo">
                    <img src="assets/img/logo_rlg.png" alt="Louis_Guilloux" class="logo_standard" />
                </a>
                <ul id="nav-mobile" class="right hide-on-med-and-down">
                    <li>Application Louis Guilloux</li>
                    <li>&nbsp;&nbsp;</li>
                    <li>&nbsp;&nbsp;</li>
                    <li>&nbsp;&nbsp;</li> 
                    <li><?php echo ucfirst($_SESSION['prenom']) . ' ' . strtoupper($_SESSION['nom']); ?></li>
                    <li><a href="logout.php">Déconnexion</a></li>
                </ul>
            </div>
        </nav>
        <div class="page-header">
            <div class="row" style="text-align: center;color: #1565c0; font-weight: bold;">
                BIENVENUE SUR OPENRLG, L'application de gestion du système d'information du réseau Louis Guilloux
            </div>
        </div>
        <br />
        <div class="container">
            <div class="row">
                <div class="col-sm-4 ayo">                    
                    <a href="structures/">
                        <img src="assets/img/structures.png" alt="Louis_Guilloux" class="center-block logo_intranet" style="width:100px; height: 100px;" />
                    </a>                    
                    <br />
                    <p class="text-center">Gérer les structures</p>
                </div>
                <div class="col-sm-4 ayo">                    
                    <a href="langues/">
                        <img src="assets/img/langues.jpg" alt="Louis_Guilloux" class="center-block logo_intranet" style="width:100px; height: 100px;" />
                    </a>                    
                    <br />
                    <p class="text-center">Gérer les langues</p>
                </div>
                <div class="col-sm-4 ayo">                    
                    <a href="personnes/">
                        <img src="assets/img/patients.jpg" alt="Louis_Guilloux" class="center-block logo_intranet" style="width:100px; height: 100px;" />
                    </a>
                    <br />                   
                    <p class="text-center">Gérer les personnes</p>
                </div>
            </div>
            <br />
            <div class="row">                
                <div class="col-sm-4 ayo">
                    <img src="assets/img/interventions.jpeg" alt="Louis_Guilloux" 
                         class="center-block logo_intranet" 
                         style="width:100px; height: 100px;" />
                    <p class="text-center">Gérer les interventions</p>
                </div>
                <div class="col-sm-4 ayo">                    
                    <img src="assets/img/agendas.jpg" alt="ImportExport" class="center-block logo_intranet" style="width:100px; height: 100px;" />                    
                    <p class="text-center">Gérer les agendas</p>
                </div>
                <div class="col-sm-4 ayo">&nbsp;</div>
            </div>
            <br />
            <div class="row">
                <div class="col-sm-4 ayo">                    
                    <img src="assets/img/import_export.jpg" alt="ImportExport" 
                         class="center-block logo_intranet" style="width:100px; height: 100px;" />                    
                    <p class="text-center">Import/Export</p>
                </div>
                <div class="col-sm-4 ayo">                    
                    <img src="assets/img/tableau_bord.png" alt="Tableau_bord" 
                        class="center-block logo_intranet" style="width:100px; height: 100px;" />                    
                    <p class="text-center">Tableau de bord</p>
                </div>
                <div class="col-sm-4 ayo">
                    <a href="moncompte/">
                        <img src="assets/img/mon_compte.jpeg" alt="Louis_Guilloux" class="center-block logo_intranet" style="width:100px; height: 100px;" />
                    </a>
                    <br />
                    <p class="text-center">Gérer mon compte</p>
                </div>                
            </div>
        </div>      
    </div>    
</body>

</html>