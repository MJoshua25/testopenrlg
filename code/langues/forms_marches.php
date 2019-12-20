<?php
    // Récupérer les informations
    require_once "../db/db_connect.php";
    require_once '../models/marche.model.php';
    require_once "../db/marches.php";
    require_once "../utils/langues.utils.php";

    $code = $_GET['code'];
    $message_erreur = array();
    $message_succes = "";
    $getTypeMarche = getTypeMarche();
    $marche = new Marche();
    $marche->code = $code;
    $date_debut = "";
    $date_fin = "";

    if (!empty($code)) {
        $marche = getMarcheByCode($code);
    }
    if(!empty($marche->date_debut)){
        $date_debut = date("Y-m-d",strtotime($marche->date_debut));
    }
    if(!empty($marche->date_fin)){
        $date_fin = date("Y-m-d",strtotime($marche->date_fin));   
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
        $('#deleteMarche').click(function() {
            var deleteId = $('#idMarche').val();            
            $msg = "Etes-vous certain de supprimer ce marché ?";
            if (confirm($msg)) {
                $.ajax({
                    url: '../db/removemarche.php',
                    type: 'POST',
                    data: {
                        id: deleteId
                    },
                    success: function(response) {
                        if (response == 1) {
                            window.location.href = "index.php#marchestabs";
                        } else {
                            alert('Problème lors de la suppression du marché.');
                        }
                    }
                });
            }
        });

        $('#formMarche').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '../db/addmarche.php',
                data: $('#formMarche').serialize(),
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
        <img src="../assets/img/langues.jpg" style="width: 45px; height: 45px;" /> Marchés
    </h3>
    <br />
    <form method="post" id="formMarche">
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
                                Marché ou convention public
                            </div>
                        </nav>
                        <br />
                        <div class="row">
                            <div class="input-field col s4">
                                <i class="material-icons prefix">business</i>
                                <input placeholder="Numéro du contrat" id="numerocontrat" type="text" value="<?php echo $marche->code; ?>" name="numerocontrat" />
                                <label for="name">Numéro du contrat</label>
                            </div>
                            <div class="input-field col s4">
                                <input id="nomcontrat" type="text" placeholder="Nom du contrat" value="<?php echo $marche->libelle; ?>" name="nomcontrat" />
                                <label for="name">Nom du contrat</label>
                            </div>
                            <div class="input-field col s4">&nbsp;</div>
                        </div>
                        <div class="row">
                            <div class="input-field col s4">
                                <i class="material-icons prefix">business_center</i>
                                <select name="typecontrat">
                                    <option value=""></option>
                                    <?php
                                    foreach ($getTypeMarche as $key => $value) {
                                        ?>
                                        <option value="<?php echo $key; ?>" <?php if ($key == $marche->typecontrat) echo " selected"; ?>>
                                            <?php echo $value; ?>
                                        </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <label for="name">Type contrat</label>
                            </div>
                            <div class="input-field col s4">                                
                                <input id="prix" type="text" placeholder="Prix" 
                                value="<?php echo $marche->prix; ?>" name="prix" />
                                <label for="name">Prix</label>                                
                            </div>
                            <div class="input-field col s8">&nbsp;</div>
                        </div>
                        <div class="row">
                            <div class="input-field col s4">
                                <i class="material-icons prefix">date_range</i>
                                <input id="date_debut" type="date" placeholder="Date de début" 
                                value="<?php echo $date_debut; ?>" name="date_debut" />                                
                                <label for="name">Date de début</label>                                
                            </div>
                            <div class="input-field col s4">
                                <input id="date_fin" type="date" placeholder="Date de fin" 
                                    value="<?php echo $date_fin; ?>" name="date_fin" />
                                <label for="name">Date de fin</label>                                
                            </div>
                            <div class="input-field col s4">&nbsp;</div>
                        </div>
                        <input id="code" type="hidden" name="code" value="<?php echo $marche->code; ?>" />
                        <input id="idMarche" type="hidden" name="idMarche" value="<?php echo $marche->id; ?>" />
                        <div class="section center">
                            <a class="btn waves-effect waves-light #00bfa5 teal accent-4" href="index.php#marchestabs">
                                RETOUR
                            </a>
                            &nbsp;&nbsp;
                            <button type="submit" class="waves-effect #1565c0 blue darken-3 btn">
                                Enregistrer les données
                            </button>
                            <?php
                            if (isset($marche->id) && $marche->id != "") {
                                ?>
                                <button type="button" id="deleteMarche" class="waves-effect #c62828 red darken-3 btn" value="<?php echo $marche->id . ";" . $marche->code; ?>">
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