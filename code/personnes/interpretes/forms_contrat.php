<?php
    // Récupérer les informations
    require_once "../db/db_connect.php";
    require_once '../models/contrat.model.php';
    require_once "../db/contrats.php";
    require_once '../utils/personnes.utils.php';

    $idPers = $_GET['prs'];
    $idCrt = $_GET['crt'];
    $typePeriodicite = getTypePeriodicite();
    $typeContrat = getTypeContrat();
    $contrats = getContrats($idPers, $typeContrat, $typePeriodicite, false);
    $contratEnCours = getContratByCode($idCrt);
?>
<style type="text/css" class="init">
    .nav_form {
        height: 30px;
        line-height: 30px;
    }
</style>
<script type="text/javascript" language="javascript" class="init">
    
    $(document).ready(function() {
        $('#formContratUpdate').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '../db/addcontrat.php',
                data: $('#formContratUpdate').serialize(),
                success: function(response) {
                    alert(response);                    
                    return false;
                }
            });
        });
        $('#deleteContrat').click(function() {
            var deleteId = $('#codecrt').val();
            var personneId = $('#personnefk').val();
            var codeId = $('#code').val();
            $msg = "Etes-vous certain de supprimer ce contrat?";
            if (confirm($msg)) {
                $.ajax({
                    url: '../db/removecontrat.php',
                    type: 'POST',
                    data: {
                        id: deleteId
                    },
                    success: function(response) {                        
                        if (response == 1) {
                            var lienRedirect = "index.php?code="+codeId+"&prs="+personneId+"&tpprs=int#contrattabs";
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
        <img src="../assets/img/patients.jpg" style="width: 45px; height: 45px;" /> Contrat d'un interprète
    </h3>
    <br/>
    <div class="col s12">
        <div class="row" style="color: #1565c0; font-weight: bold;">
            <h5>Modifier un contrat</h5>
        </div>
        <div class="row">
    <form method="post" id="formContratUpdate">
                <div class="row">
                    <nav class="nav_form">
                        <div class="nav-wrapper textentete #1565c0 blue darken-3"></div>
                    </nav>
                    <br />
                    <div class="row">
                        <div class="input-field col s3">
                            <i class="material-icons prefix">assignment</i>                            
                            <select name="typecontrat">
                                <option value=""></option>
                                <?php
                                foreach ($typeContrat as $key => $tcontrat) {
                                    ?>
                                    <option value="<?php echo $key; ?>" <?php if($contratEnCours->typecontrat == $key) echo " selected"; ?>>
                                        <?php echo $tcontrat; ?>
                                    </option>
                                <?php
                                }
                                ?>
                            </select>
                            <label for="typecontrat">Type de contrat</label>
                        </div>
                        <div class="input-field col s3">
                            <input id="date_contrat" type="date" 
                                placeholder="Date du contrat" 
                                name="date_contrat" value="<?php echo date("Y-m-d",strtotime($contratEnCours->date_contrat)); ?>"/>
                            <label for="date_contrat">Date du contrat</label>
                        </div>
                        <div class="input-field col s3">
                            <input id="nb_heures" type="text" placeholder="Nombre d'heures" 
                                name="nb_heures" value="<?php echo $contratEnCours->nb_heures; ?>"/>
                            <label for="nb_heures">Nombre d'heures</label>
                        </div>
                        <div class="input-field col s3">
                            <select name="type_periodicite">
                                <option value=""></option>
                                <?php
                                foreach ($typePeriodicite as $key => $tperiode) {
                                ?>
                                    <option value="<?php echo $key; ?>" 
                                    <?php if($contratEnCours->periodicite == $key) echo " selected";?>>
                                        <?php echo $tperiode; ?>
                                    </option>
                                <?php
                                }
                                ?>
                            </select>
                            <label for="type_periodicite">Périodicité</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s3">
                            <input id="date_medecin_travail" type="date" 
                            placeholder="Médecine du travail" 
                            name="date_medecin_travail" value="<?php echo date("Y-m-d",strtotime($contratEnCours->date_medecin_travail)); ?>"/>                            
                            <label for="date_medecin_travail">Médecine du travail</label>
                        </div>
                        <div class="input-field col s3">
                            <input id="entretien_individuel" type="date" 
                                    placeholder="Entretien individuel" 
                                    name="entretien_individuel" 
                                    value="<?php echo date("Y-m-d",strtotime($contratEnCours->date_entretien)); ?>"/>
                            <label for="entretien_individuel">Entretien individuel</label>
                        </div>
                        <div class="input-field col s6">
                            <input id="entretien_stagiaire" type="text" 
                            placeholder="Entretien avec stagiaire" 
                            name="entretien_stagiaire" 
                            value="<?php echo $contratEnCours->entretien_stagiaire; ?>"/>
                            <label for="entretien_stagiaire">Entretien avec stagiaire</label>
                        </div>
                    </div>
                    <div class="section center">
                        <input id="personnefk" type="hidden" name="personnefk" value="<?php echo $_GET['prs']; ?>" />
                        <input id="codecrt" type="hidden" name="codecrt" value="<?php echo $_GET['crt']; ?>" />
                        <input id="code" type="hidden" name="code" value="<?php echo $_GET['code']; ?>" />
                        &nbsp;&nbsp;
                        <a class="btn waves-effect waves-light #00bfa5 teal accent-4" href="index.php?code=<?php echo $_GET['code']; ?>&prs=<?php echo $_GET['prs']; ?>&tpprs=int#contrattabs">
                            RETOUR
                        </a>
                        <button type="submit" class="waves-effect #1565c0 blue darken-3 btn">
                            Enregistrer les données
                        </button>
                        <button type="button" id="deleteContrat" class="waves-effect #c62828 red darken-3 btn">
                            Supprimer
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>