<?php
    // Récupérer les informations
    require_once "../db/db_connect.php";
    require_once '../models/professionnel.model.php';
    require_once '../utils/email.utils.php';
    require_once "../db/professionnels.php";
    require_once "../db/structures.php";
    require_once '../utils/structures.utils.php';

    $code = $_GET['code'];
    $message_erreur = array();
    $message_succes = "";
    $professionnel = new Professionnel();
    $professionnel->id = $code;
    $listeStructure = getStructures(getTypeOrganisme(), getTypeStructure());

    if (!empty($code) && $code != 'vide') {
        $professionnel = getProfessionnelByCode($code);
    }
?>
<style type="text/css" class="init">
    .nav_form {
        height: 30px;
        line-height: 30px;
    }
</style>
<script type="text/javascript" language="javascript">
    $(document).ready(function() {
        $('#deleteProfessionnel').click(function() {
            var deleteId = $('#personnefk').val();
            $msg = "Etes-vous certain de supprimer cette personne?";
            if (confirm($msg)) {
                $.ajax({
                    url: '../db/removeprofessionnel.php',
                    type: 'POST',
                    data: {
                        id: deleteId
                    },
                    success: function(response) {                        
                        if (response == 1) {
                            window.location.href = "index.php#professionnelstabs";
                        } else {                            
                            alert('Problème lors de la suppression de la langue.');
                        }
                    }
                });
            }
        });

        $('#formProfessionnel').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '../db/addprofessionnel.php',
                data: $('#formProfessionnel').serialize(),
                success: function(response) {
                    alert(response);
                    $('html').animate({
                        scrollTop: 0
                    }, 'speed');
                    return false;
                }
            });
        });
    });
</script>
<div class="container">
    <h3>
        <img src="../assets/img/patients.jpg" style="width: 45px; height: 45px;" /> Professionnels
    </h3>
    <br/>    
    <a class="btn waves-effect waves-light #1565c0 blue darken-3" href="index.php#professionnelstabs">
    < < < Retour
    </a>
    <br/>
    <form method="post" id="formProfessionnel">
        <div class="row">
            <div class="row" style="color: red; font-weight: bold;">
                <?php
                if (!empty($message_erreur)) {
                    ?>
                    <br />
                    Les champs suivants sont obligatoires :
                    <ul>
                        <?php
                            foreach ($message_erreur as $msg) {
                                echo "<li> - " . $msg . "</li>";
                            }
                            ?>
                    </ul>
                <?php
                }
                ?>
            </div>
            <div class="row">
                <div class="col s10 offset-s1">
                    <?php
                    if (!empty($message_succes)) {
                        ?>
                        <h5 style="color: #ff6f00; font-weight: bold; ">
                            <?php
                                echo $message_succes;
                                ?>
                        </h5>
                        <br />
                    <?php
                    }
                    ?>
                    <div class="card-panel">
                        <nav class="nav_form">
                            <div class="nav-wrapper textentete #1565c0 blue darken-3" style="text-align: center;font-weight: bold;">
                                Professionnels
                            </div>
                        </nav>
                        <br />
                        <div class="row">
                            <div class="input-field col s6">
                                <i class="material-icons prefix">person</i>
                                <select name="civilite">
                                    <option value=""></option>
                                    <option value="Mr" <?php if ($professionnel->code_civilite == "Mr") echo " selected"; ?>>Mr</option>
                                    <option value="Mme" <?php if ($professionnel->code_civilite == "Mme") echo " selected"; ?>>Mme</option>
                                    <option value="Mlle" <?php if ($professionnel->code_civilite == "Mlle") echo " selected"; ?>>Mlle</option>
                                </select>
                                <label for="name">Civilité</label>
                            </div>

                            <div class="input-field col s6">
                                <i class="material-icons prefix">people</i>
                                <select name="sexe">
                                    <option value=""></option>
                                    <option value="1" <?php if ($professionnel->code_sexe == "1") echo " selected"; ?>>Masculin</option>
                                    <option value="2" <?php if ($professionnel->code_sexe == "2") echo " selected"; ?>>Féminin</option>
                                </select>
                                <label>Sexe</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s6">
                                <i class="material-icons prefix">account_circle</i>
                                <input placeholder="Nom" id="nom" type="text" name="nom" value="<?php echo $professionnel->nom; ?>" />
                                <label for="name">Nom</label>
                            </div>
                            <div class="input-field col s6">
                                <input id="prenom" type="text" placeholder="Prenom" name="prenom" value="<?php echo $professionnel->prenom; ?>" />
                                <label for="name">Prenom</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s6">
                                <i class="material-icons prefix">email</i>
                                <input placeholder="Email" id="email" type="text" name="email" value="<?php echo $professionnel->email; ?>" />
                                <label for="name">Email</label>
                            </div>
                            <div class="input-field col s6">
                                <select name="role">
                                    <option value=""></option>
                                    <option value="RPFS" <?php if ($professionnel->role == "RPFS") echo " selected"; ?>>Professionnel</option>                                    
                                    <option value="RPINT" <?php if ($professionnel->role == "RPINT") echo " selected"; ?>>Pôle interpretariat</option>
                                    <option value="RCAM" <?php if ($professionnel->role == "RCAM") echo " selected"; ?>>Pôle cabinet médical</option>
                                </select>
                                <label for="name">Rôle</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s6">
                                <i class="material-icons prefix">business</i>
                                <select name="structurefk">
                                    <option value=""></option>
                                    <?php
                                    foreach ($listeStructure as $structure) {
                                        ?>
                                        <option value="<?php echo $structure['id']; ?>" <?php if ($structure['id'] == $professionnel->structurefk) echo " selected"; ?>>
                                            <?php echo $structure['libelle'] . " - " . $structure['ville']; ?>
                                        </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <label for="name">Structure ou organisme</label>
                            </div>
                            <div class="input-field col s6">                            
                                <label for="actif">
                                    <input type="checkbox" id="actif" name="actif" class="filled-in" <?php if ($professionnel->token_activation == "1") echo " checked='checked'"; ?> />
                                    <span>Actif</span>
                                </label>
                            </div>
                        </div>
                        <br />
                        <nav class="nav_form">
                            <div class="nav-wrapper textentete #1565c0 blue darken-3" style="text-align: center;font-weight: bold;">
                                &nbsp;&nbsp;
                            </div>
                        </nav>
                        <br />
                        <input id="code" type="hidden" name="code" value="<?php echo $professionnel->id; ?>" />
                        <input id="personnefk" type="hidden" name="personnefk" value="<?php echo $professionnel->personnefk; ?>" />
                        <div class="section center">
                            <a class="btn waves-effect waves-light #00bfa5 teal accent-4" href="index.php#professionnelstabs">
                                RETOUR
                            </a>
                            &nbsp;&nbsp;
                            <button type="submit" class="waves-effect #1565c0 blue darken-3 btn">
                                Enregistrer les données
                            </button>
                            <?php                            
                            if (isset($professionnel->id) && $professionnel->id != "") {
                                ?>
                                <button type="button" id="deleteProfessionnel" class="waves-effect #c62828 red darken-3 btn">
                                    Supprimer
                                </button>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>