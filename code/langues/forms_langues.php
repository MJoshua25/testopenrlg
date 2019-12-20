<?php
    // Récupérer les informations
    require_once "../db/db_connect.php";
    require_once '../models/langue.model.php';
    require_once "../db/langues.php";
    require_once "../db/lotslangues.php";
    require_once "../utils/langues.utils.php";

    $code = $_GET['code'];
    $message_erreur = array();
    $message_succes = "";
    $langue = new Langue();
    $langue->code = $code;
    $lotslangues = getLotsLangues();

    if (!empty($code) && $code != 'vide') {
        $langue = getLangueByCode($code);
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
        $('#deleteLangue').click(function() {
            var deleteId = $('#idLangue').val();
            $msg = "Etes-vous certain de supprimer cette langue?";
            if (confirm($msg)) {
                $.ajax({
                    url: '../db/removelangue.php',
                    type: 'POST',
                    data: {
                        id: deleteId
                    },
                    success: function(response) {
                        if (response == 1) {
                            window.location.href = "index.php#languestabs";
                        } else {
                            alert('Problème lors de la suppression de la langue.');
                        }
                    }
                });
            }
        });

        $('#formLangue').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '../db/addlangue.php',
                data: $('#formLangue').serialize(),
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
        <img src="../assets/img/langues.jpg" style="width: 45px; height: 45px;" /> Langues
    </h3>
    <br />
    <form method="post" id="formLangue">
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
                            <div class="nav-wrapper textentete #1565c0 blue darken-3" style="text-align: center;font-weight: bold;">Langues</div>
                        </nav>
                        <br />
                        <div class="row">
                            <div class="input-field col s4">
                                <i class="material-icons prefix">business</i>
                                <input placeholder="Nom" id="libelleLangue" type="text" name="libelleLangue" value="<?php echo $langue->libelle; ?>" />
                                <label for="name">Libellé de la langue</label>
                            </div>
                        </div>

                        <div class="row">                            
                            <div class="input-field col s4">
                                <i class="material-icons prefix">language</i>
                                <select name="lotlanguefk">
                                    <option value=""></option>
                                    <?php
                                    foreach ($lotslangues as $lotlangue) {
                                        ?>
                                        <option value="<?php echo $lotlangue['id']; ?>" <?php if ($lotlangue['id'] == $langue->lotlanguefk) echo " selected"; ?>>
                                            <?php echo $lotlangue['libelle']; ?>
                                        </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <label for="name">Lots de langues</label>
                            </div>
                        </div>

                        <input id="code" type="hidden" name="code" value="<?php echo $langue->code; ?>" />
                        <input id="idLangue" type="hidden" name="idLangue" value="<?php echo $langue->id; ?>" />
                        <div class="section center">
                            <a class="btn waves-effect waves-light #00bfa5 teal accent-4" href="index.php">
                                RETOUR
                            </a>
                            &nbsp;&nbsp;
                            <button type="submit" class="waves-effect #1565c0 blue darken-3 btn">
                                Enregistrer les données
                            </button>
                            <?php                            
                            if (isset($langue->id) && ($langue->id != "")) {
                                ?>
                                <button type="button" id="deleteLangue" class="waves-effect #c62828 red darken-3 btn" value="<?php echo $langue->id . ";" . $langue->code; ?>">
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