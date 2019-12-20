<?php
// Récupérer les informations
require_once "../db/db_connect.php";
require_once '../models/structure.model.php';
require_once '../models/site.model.php';
require_once "../db/structures.php";
require_once "../db/sites.php";
require_once "../utils/structures.utils.php";

$code = $_GET['code'];
$message_erreur = array();
$message_succes = "";
$structure = new Structure();
$structure->code = $code;

if (!empty($code) && $code != 'vide') {
    $structure = getStructureByCode($code);
}
$siteEnable = " none;";
$getTypeorganisme = getTypeOrganisme();
$getTypestructure = getTypeStructure();
$sites = array();
if (isset($structure->id)) {
    $sites = getSites($structure->id);
}
if ($structure->typestructure == "HOPITAUX") {
    $siteEnable = " block;";
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
        $('#deleteStructure').click(function() {
            var deleteId = $('#idStruct').val();
            $msg = "Etes-vous certain de supprimer cette structure?";
            if (confirm($msg)) {
                $.ajax({
                    url: '../db/removestructure.php',
                    type: 'POST',
                    data: {
                        id: deleteId
                    },
                    success: function(response) {
                        if (response == 1) {
                            window.location.href = "index.php";
                        } else {
                            alert('Problème lors de la suppression de la structure.');
                        }
                    }
                });
            }
        });

        $('#typestructure').change(function() {
            const valeur = $(this).val();
            const id = $("#idStruct").val();
            if (valeur == "HOPITAUX" && id != "") {
                $("#sitepart").css("display", "block");
            } else {
                $("#sitepart").css("display", "none");
            }
        });

        $('#formStructure').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '../db/addstructure.php',
                data: $('#formStructure').serialize(),
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
        <img src="../assets/img/structures.png" style="width: 45px; height: 45px;" /> Structures
    </h3>
    <br />
    <a class="btn waves-effect waves-light #1565c0 blue darken-3" href="index.php">
        < < < Retour à la liste
    </a>
    <br/>
    <br/>    
    <form method="post" id="formStructure">
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
                            <div class="nav-wrapper textentete #1565c0 blue darken-3" style="text-align: center;font-weight: bold;">Identité</div>
                        </nav>
                        <br />
                        <div class="row">
                            <div class="input-field col s4">
                                <i class="material-icons prefix">business</i>
                                <input placeholder="Nom" id="libelleStruct" type="text" name="libelleStruct" value="<?php echo $structure->libelle; ?>" />
                                <label for="name">Nom de l'organisme</label>
                            </div>
                            <div class="input-field col s4">
                                <select name="typeorganisme">
                                    <option value=""></option>
                                    <?php
                                    foreach ($getTypeorganisme as $key => $value) {
                                        ?>
                                        <option value="<?php echo $key; ?>" <?php if ($key == $structure->typeorganisme) echo " selected"; ?>>
                                            <?php echo $value; ?>
                                        </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <label for="name">Type d'organisme</label>
                            </div>
                            <div class="input-field col s4">
                                <select name="typestructure" id="typestructure">
                                    <option value=""></option>
                                    <?php
                                    foreach ($getTypestructure as $key => $value) {
                                        ?>
                                        <option value="<?php echo $key; ?>" <?php if ($key == $structure->typestructure) echo " selected"; ?>>
                                            <?php echo $value; ?>
                                        </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <label for="name">Type de structure</label>
                            </div>
                        </div>
                        <nav class="nav_form">
                            <div class="nav-wrapper textentete #1565c0 blue darken-3" style="text-align: center;font-weight: bold;">Adresse administrative</div>
                        </nav>
                        <br />
                        <div class="row">
                            <div class="input-field col s4">
                                <i class="material-icons prefix">business</i>
                                <input placeholder="Adresse" id="adresse" type="text" value="<?php echo $structure->adresse1; ?>" name="adresse" />
                                <label for="name">Adresse</label>
                            </div>
                            <div class="input-field col s4">
                                <input id="adresse2" type="text" placeholder="Compléments d'adresse" value="<?php echo $structure->adresse2; ?>" name="adresse2" />
                                <label for="name">Compléments d'adresse</label>
                            </div>
                            <div class="input-field col s4">&nbsp;</div>
                        </div>
                        <div class="row">
                            <div class="input-field col s4">
                                <i class="material-icons prefix">business</i>
                                <input id="codepostal" type="text" placeholder="code postal" value="<?php echo $structure->code_postal; ?>" name="codepostal" />
                                <label for="name">Code postal</label>
                            </div>
                            <div class="input-field col s4">
                                <i class="material-icons prefix">location_city</i>
                                <input id="ville" type="text" placeholder="Localité" value="<?php echo $structure->ville; ?>" name="ville" />
                                <label for="name">Localité</label>
                            </div>
                            <div class="input-field col s4">&nbsp;</div>
                        </div>
                        <nav class="nav_form">
                            <div class="nav-wrapper textentete #1565c0 blue darken-3" style="text-align: center;font-weight: bold;">Contacts</div>
                        </nav>
                        <br />
                        <div class="row">
                            <div class="input-field col s4">
                                <i class="material-icons prefix">phone</i>
                                <input id="telephone" type="text" placeholder="Telephone" value="<?php echo $structure->telephone; ?>" name="telephone" />
                                <label for="name">Téléphone</label>
                            </div>
                            <div class="input-field col s4">
                                <input id="fax" type="text" placeholder="Fax" value="<?php echo $structure->fax; ?>" name="fax" />
                                <label for="fax">Fax</label>
                            </div>
                            <div class="input-field col s4">
                                <i class="material-icons prefix">email</i>
                                <input id="email" type="text" placeholder="Email" value="<?php echo $structure->email; ?>" name="email" />
                                <label for="name">Email</label>
                            </div>
                        </div>
                        <div class="row" id="sitepart" style="display: <?php echo $siteEnable; ?>;">
                            <nav class="nav_form">
                                <div class="nav-wrapper textentete #1565c0 blue darken-3" style="text-align: center;font-weight: bold;">
                                    Sites
                                </div>
                            </nav>
                            <br />
                            <div class="row">
                                <a class="btn waves-effect waves-light #1565c0 blue darken-3" href="index.php?code=<?php echo $structure->code; ?>&codeSite=vide">
                                    Créer un nouveau site
                                </a>
                            </div>
                            <?php
                            if (count($sites) > 0) {
                                ?>

                                <?php
                                    foreach ($sites as $site) {
                                        ?>
                                    <div class="row">
                                        <div class="col s4">
                                            <?php echo $site['libelle']; ?>
                                        </div>
                                        <div class="col s4">
                                            <?php echo $site['adresse1']; ?>
                                        </div>
                                        <div class="col s3">
                                            <?php echo $site['ville']; ?>
                                        </div>
                                        <div class="col s1">
                                            <a class="material-icons prefix modal-trigger" href="<?php echo "?code=" . $code . "&codeSite=" . $site['code'] . ""; ?>">create</a>
                                        </div>
                                    </div>
                            <?php
                                }
                            }
                            ?>
                        </div>
                        <input id="code" type="hidden" name="code" value="<?php echo $structure->code; ?>" />
                        <input id="idStruct" type="hidden" name="idStruct" value="<?php echo $structure->id; ?>" />
                        <div class="section center">
                            <a class="btn waves-effect waves-light #00bfa5 teal accent-4" href="index.php">
                                RETOUR
                            </a>
                            &nbsp;&nbsp;
                            <button type="submit" class="waves-effect #1565c0 blue darken-3 btn">
                                Enregistrer les données
                            </button>
                            <?php
                            if (isset($structure->id)) {
                            ?>
                            <button type="button" id="deleteStructure" class="waves-effect #c62828 red darken-3 btn">
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