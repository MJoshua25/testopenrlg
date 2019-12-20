<?php
    // Récupérer les informations
    require_once "../db/db_connect.php";
    require_once '../models/lotlangues.model.php';
    require_once "../db/lotslangues.php";
    require_once '../db/marches.php';
    require_once '../utils/langues.utils.php';

    $message_erreur = array();
    $message_succes = "";
    $typemarche = getTypeMarche();
    $marches = getMarches($typemarche);
    $code = $_GET['code'];
    $lotlangues = new LotLangues();
    $lotlangues->code = $code;
    if (!empty($code) && $code != "vide") {
        $lotlangues = getLotLanguesByCode($code);
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
        $('#deleteLotlangues').click(function() {
            var deleteId = $('#idLotlangues').val();
            $msg = "Etes-vous certain de supprimer ce lot de langues?";
            if (confirm($msg)) {
                $.ajax({
                    url: '../db/removelotlangues.php',
                    type: 'POST',
                    data: {
                        id: deleteId
                    },
                    success: function(response) {
                        if (response == 1) {
                            window.location.href = "index.php#lotslanguestabs";
                        } else {
                            alert('Problème lors de la suppression de la structure.');
                        }
                    }
                });
            }
        });

        $('#formLotLangues').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '../db/addlotlangues.php',
                data: $('#formLotLangues').serialize(),
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
        <img src="../assets/img/langues.jpg" style="width: 45px; height: 45px;" /> Lots de langues
    </h3>
    <br />
    <form method="post" id="formLotLangues">
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
                            <div class="nav-wrapper textentete #1565c0 blue darken-3" style="text-align: center;font-weight: bold;">Lot de langues</div>
                        </nav>
                        <br />
                        <div class="row">
                            <div class="input-field col s4">
                                <i class="material-icons prefix">language</i>
                                <input placeholder="Nom" id="libelleLotLangues" type="text" name="libelleLotLangues" value="<?php echo  $lotlangues->libelle; ?>" />
                                <label for="name">Nom du lot</label>
                            </div>
                            <div class="input-field col s8">&nbsp;</div>
                        </div>
                        <div class="row">
                            <div class="input-field col s4">
                                <i class="material-icons prefix">business</i>
                                <select name="marcheconvention" id="marcheconvention">
                                    <option value=""></option>
                                    <?php
                                    foreach ($marches as $marche) {
                                        ?>
                                        <option value="<?php echo $marche['id']; ?>" <?php if ($marche['id'] == $lotlangues->marchefk) echo " selected"; ?>>
                                            <?php echo $marche['libelle']; ?>
                                        </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <label for="name">Marché/Convention</label>
                            </div>
                            <div class="input-field col s8">&nbsp;</div>
                        </div>

                        <input id="code" type="hidden" name="code" value="<?php echo $lotlangues->code; ?>" />
                        <input id="idLotlangues" type="hidden" name="idLotlangues" value="<?php echo $lotlangues->id; ?>" />
                        <div class="section center">
                            <a class="btn waves-effect waves-light #00bfa5 teal accent-4" href="index.php#lotslanguestabs">
                                RETOUR
                            </a>
                            &nbsp;&nbsp;
                            <button type="submit" class="waves-effect #1565c0 blue darken-3 btn">
                                Enregistrer les données
                            </button>
                            <?php                            
                            if (isset($lotlangues->id) && ($lotlangues->id != "")) {
                            ?>
                            <button type="button" id="deleteLotlangues" class="waves-effect #c62828 red darken-3 btn" value="<?php echo $lotlangues->id . ";" . $lotlangues->code; ?>">
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