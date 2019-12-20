<?php
    // Récupérer les informations
    require_once "../db/db_connect.php";
    require_once '../models/langues.interprete.model.php';
    require_once '../models/langue.model.php';
    require_once "../db/languesInterpretes.php";
    require_once "../db/langues.php";

    $idPers = $_GET['prs'];
    $idLgnInt = $_GET['lngint'];    
    $langues = getLangues();
    $langueIntEnCours = getLanguesInterpreteByPersoLangue($idPers, $idLgnInt);    
?>
<style type="text/css" class="init">
    .nav_form {
        height: 30px;
        line-height: 30px;
    }
</style>
<script type="text/javascript" language="javascript" class="init">
    $(document).ready(function() {
        $('#formLangueIntUpdate').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '../db/addlangueInterprete.php',
                data: $('#formLangueIntUpdate').serialize(),
                success: function(response) {
                    alert(response);
                    return false;
                }
            });
        });
        $('#deleteformLangueIntUpdate').click(function() {
            var deleteId = $('#codelngint').val();
            var personneId = $('#personnefk').val();
            var codeId = $('#code').val();
            var langueId = $('#languefk').val();
            $msg = "Etes-vous certain de supprimer cette langue?";
            if (confirm($msg)) {
                $.ajax({
                    url: '../db/removelangueInterprete.php',
                    type: 'POST',
                    data: {
                        id: deleteId,
                        personnefk: personneId,
                        languefk: langueId
                    },
                    success: function(response) {                        
                        if (response == 1) {
                            var lienRedirect = "index.php?code=" + codeId + "&prs=" + personneId + "&tpprs=int#languetabs";
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
            <form method="post" id="formLangueIntUpdate">
                <div class="row">
                    <nav class="nav_form">
                        <div class="nav-wrapper textentete #1565c0 blue darken-3"></div>
                    </nav>
                    <br />
                    <div class="row">
                    <div class="input-field col s3">
                        <select name="langue">
                        <option value=""></option>
                                <?php
                                foreach ($langues as $langue) {
                                ?>
                                    <option value="<?php echo $langue['id']; ?>" <?php if($langue['id'] == $langueIntEnCours->languefk) echo " selected"; ?>>
                                        <?php echo $langue['libelle']; ?>
                                    </option>
                                <?php
                                }
                                ?>
                            </select>
                            <label for="typecontrat">Langues</label>
                        </div> 
                        <div class="input-field col s3">                            
                            <label>
                                <input type="checkbox" name="orale" 
                                    class="filled-in yellow" <?php if($langueIntEnCours->langue_orale == 1) echo " checked='checked'";?>/>
                                <span>Orale</span>
                            </label>
                        </div>
                        <div class="input-field col s3">                            
                            <label>
                                <input type="checkbox" name="ecrite" 
                                    class="filled-in" <?php if($langueIntEnCours->langue_ecrite == 1) echo " checked='checked'";?>/>
                                <span>Ecrite</span>
                            </label>
                        </div>
                    </div>

                    <div class="section center">
                        <input id="personnefk" type="hidden" name="personnefk" value="<?php echo $_GET['prs']; ?>" />
                        <input id="codelngint" type="hidden" name="codelngint" value="<?php echo $_GET['lngint']; ?>" />
                        <input id="code" type="hidden" name="code" value="<?php echo $_GET['code']; ?>" />
                        <input id="languefk" type="hidden" name="languefk" value="<?php echo $langueIntEnCours->languefk; ?>" />
                        &nbsp;&nbsp;
                        <a class="btn waves-effect waves-light #00bfa5 teal accent-4" href="index.php?code=<?php echo $_GET['code']; ?>&prs=<?php echo $_GET['prs']; ?>&tpprs=int#languetabs">
                            RETOUR
                        </a>
                        <button type="submit" class="waves-effect #1565c0 blue darken-3 btn">
                            Enregistrer les données
                        </button>
                        <button type="button" id="deleteformLangueIntUpdate" class="waves-effect #c62828 red darken-3 btn">
                            Supprimer
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>