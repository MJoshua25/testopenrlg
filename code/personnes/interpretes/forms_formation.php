<?php
// Récupérer les informations
require_once "../db/db_connect.php";
require_once '../models/formation.model.php';
require_once "../db/formations.php";
require_once '../utils/personnes.utils.php';

$idPers = $_GET['prs'];
$idFrt = $_GET['frt'];
$typeFormation = getTypeFormation();
$formations = getFormations($_GET['prs'], $typeFormation);
$formationEnCours = getFormationByCode($idFrt);
?>
<style type="text/css" class="init">
    .nav_form {
        height: 30px;
        line-height: 30px;
    }
</style>
<script type="text/javascript" language="javascript" class="init">
    $(document).ready(function() {
        $('#formFormationUpdate').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '../db/addformation.php',
                data: $('#formFormationUpdate').serialize(),
                success: function(response) {
                    alert(response);
                    return false;
                }
            });
        });
        $('#deleteFormation').click(function() {
            var deleteId = $('#codefrt').val();
            var personneId = $('#personnefk').val();
            var codeId = $('#code').val();
            $msg = "Etes-vous certain de supprimer cette formation?";
            if (confirm($msg)) {
                $.ajax({
                    url: '../db/removeformation.php',
                    type: 'POST',
                    data: {
                        id: deleteId
                    },
                    success: function(response) {
                        if (response == 1) {
                            var lienRedirect = "index.php?code=" + codeId + "&prs=" + personneId + "&tpprs=int#formationtabs";
                            window.location.href = lienRedirect;
                        } else {
                            alert('Problème lors de la suppression du contrat.');
                        }
                    }
                });
            }
        });
    });
</script>
<div class="container">
    <h3>
        <img src="../assets/img/patients.jpg" style="width: 45px; height: 45px;" /> Formation d'un interprète
    </h3>
    <br />
    <div class="col s12">
        <div class="row" style="color: #1565c0; font-weight: bold;">
            <h5>Modifier une formation</h5>
        </div>
        <div class="row">
            <form method="post" id="formFormationUpdate">
                <div class="row">
                    <nav class="nav_form">
                        <div class="nav-wrapper textentete #1565c0 blue darken-3"></div>
                    </nav>
                    <br />
                    <div class="row">
                        <div class="input-field col s3">
                            <input id="date_formation" type="date" placeholder="Date de formation" 
                            name="date_formation" 
                            value="<?php echo date("Y-m-d",strtotime($formationEnCours->date_formation)); ?>"/>
                            <label for="date_formation">Date de formation</label>
                        </div>
                        <div class="input-field col s3">
                            <input id="sujet" type="text" placeholder="Sujet" 
                                name="sujet" value="<?php echo $formationEnCours->sujet; ?>"/>
                            <label for="sujet">Sujet</label>
                        </div>
                        <div class="input-field col s3">
                            <select name="type_formation">
                                <option value=""></option>
                                <?php
                                foreach ($typeFormation as $key => $tformation) {
                                    ?>
                                    <option value="<?php echo $key; ?>" <?php if($formationEnCours->type_formation == $key) echo " selected"; ?>>
                                        <?php echo $tformation; ?>
                                    </option>
                                <?php
                                }
                                ?>
                            </select>
                            <label for="typecontrat">Type de format<ion</label> </div> <div class="input-field col s3">
                            <input id="analyse_formation" type="text" 
                                placeholder="Analyse de la formation" 
                                name="analyse_formation" 
                                value="<?php echo $formationEnCours->analyse_formation; ?>"/>
                            <label for="analyse_formation">Analyse de la formation</label>
                        </div>
                    </div>

                    <div class="section center">
                        <input id="personnefk" type="hidden" name="personnefk" value="<?php echo $_GET['prs']; ?>" />
                        <input id="codefrt" type="hidden" name="codefrt" value="<?php echo $_GET['frt']; ?>" />
                        <input id="code" type="hidden" name="code" value="<?php echo $_GET['code']; ?>" />
                        &nbsp;&nbsp;
                        <a class="btn waves-effect waves-light #00bfa5 teal accent-4" href="index.php?code=<?php echo $_GET['code']; ?>&prs=<?php echo $_GET['prs']; ?>&tpprs=int#formationtabs">
                            RETOUR
                        </a>
                        <button type="submit" class="waves-effect #1565c0 blue darken-3 btn">
                            Enregistrer les données
                        </button>
                        <button type="button" id="deleteFormation" class="waves-effect #c62828 red darken-33 btn">
                            Supprimer
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>