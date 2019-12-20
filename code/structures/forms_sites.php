<?php
    // Récupérer les informations
    require_once "../db/db_connect.php";
    require_once '../models/structure.model.php';
    require_once '../models/site.model.php';
    require_once "../db/structures.php";
    require_once "../db/sites.php";
    require_once "../db/services.php";
    require_once "../db/unitefonctionnelles.php";

    $code = $_GET['code'];
    $codeSite = $_GET['codeSite'];
    $structure = getStructureByCode($code);
    $site = new Site();
    if (isset($_GET['codeSite'])) {
        if (!empty($codeSite) && $codeSite != 'vide') {
            $site = getSiteByCode($codeSite);
        }
    }

    $services = array();
    $ufbySite = array();
    if (isset($site->id) && !empty($site->id)) {
        $services = getServices($site->id);
        $ufbySite = getUniteFonctionnellesBySite($site->id);
    }
?>
<style type="text/css" class="init">
</style>
<script type="text/javascript" language="javascript">
    let maxUf = <?php echo count($ufbySite) ?>
    $(document).ready(function() {
        $('#deleteSite').click(function() {
            const deleteId = $('#idSite').val();
            const codeStruct = $('#code').val();
            $msg = "Etes-vous certain de supprimer ce site?";
            if (confirm($msg)) {
                $.ajax({
                    url: '../db/removesite.php',
                    type: 'POST',
                    data: {
                        id: deleteId
                    },
                    success: function(response) {
                        if (response == 1) {
                            window.location.href = "index.php?code=" + codeStruct + "";
                        } else {
                            alert('Problème lors de la suppression de la site.');
                        }
                    }
                });
            }
        });
        $('#addBtnServiceUf').click(function() {
            const html = addHtmlDiv(maxUf);
            $('#addServiceUf').append(html);
        });
        $('#formSite').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '../db/addsite.php',
                data: $('#formSite').serialize(),
                success: function(response) {
                    $('#msgErrorSuccess').text(response);
                }
            });
        });
    });

    function addHtmlDiv($i_uf) {
        var $html = "<div class='row' id='svr_uf" + $i_uf + "'>";
        $html += "<div class='input-field col s4'><i class='material-icons prefix'>business</i>";
        $html += "<input placeholder='service' id='libelleService_" + $i_uf + "'";
        $html += " type='text' name='libelleService_" + $i_uf + "'";
        $html += " value='' /></div>";
        $html += "<div class='input-field col s4'>";
        //$html += "<i class='material-icons prefix'>business</i>";
        $html += "<input placeholder='unite fonctionnelle' id='libelleUf_" + $i_uf + "'";
        $html += " type='text' name='libelleUf_" + $i_uf + "' value='' />";
        $html += "</div>"
        $html += "<div class='input-field col s4'";
        $html += " onclick='removeHtml(svr_uf" + $i_uf + ")'>";
        $html += "<i class='material-icons prefix' style='cursor:pointer;'>delete</i>";
        $html += "</div>";
        $html += "</div>";

        maxUf += 1;
        return $html;
    }

    function removeHtml(idHtmlRemove) {
        if (confirm("Etes-vous certains de supprimer cet unité fonctionnelle ?")) {
            $(idHtmlRemove).remove();
        }
    }
</script>
<div class="container">
    <h3>
        <img src="../assets/img/structures.png" style="width: 45px; height: 45px;" /> Structures
    </h3>
    <br />
    <a class="btn waves-effect waves-light #1565c0 blue darken-3" href="index.php?code=<?php echo $_GET['code'];?>">
    < < < Retour
    </a>
    <br/>
    <br/>
    <form method="post" id="formSite">
        <div class="row">
            <div class="col s10 offset-s1">
                <div class="row" style="color: #ff6f00; font-weight: bold;">
                    <h5 id="msgErrorSuccess"></h5>
                </div>
                <div class="card-panel">
                    <nav class="nav_form">
                        <div class="nav-wrapper textentete #1565c0 blue darken-3" style="text-align: center;font-weight: bold;">
                            Site
                        </div>
                    </nav>
                    <br />
                    <div class="row">
                        <div class="input-field col s4">
                            <i class="material-icons prefix">business</i>
                            <input placeholder="Libelle du site" id="libelleSite" type="text" name="libelleSite" value="<?php echo $site->libelle; ?>" />
                            <label for="name">Libelle du site</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s4">
                            <i class="material-icons prefix">business</i>
                            <input placeholder="Adresse du site" id="adresseSite" type="text" name="adresseSite" value="<?php echo $site->adresse1; ?>" />
                            <label for="name">Adresse</label>
                        </div>
                        <div class="input-field col s4">
                            <i class="material-icons prefix">business</i>
                            <input placeholder="Code postal du site" id="codePostalSite" type="text" name="codePostalSite" value="<?php echo $site->code_postal; ?>" />
                            <label for="name">Code postal</label>
                        </div>
                        <div class="input-field col s4">
                            <i class="material-icons prefix">business</i>
                            <input placeholder="Ville du site" id="villeSitevilleSite" type="text" name="villeSite" value="<?php echo $site->ville; ?>" />
                            <label for="name">Ville</label>
                        </div>
                    </div>
                    <nav class="nav_form">
                        <div class="nav-wrapper textentete #1565c0 blue darken-3" style="text-align: center;font-weight: bold;">
                            Services / Unités fonctionnelles
                        </div>
                    </nav>
                    <br />
                    <div class="row">
                        <button type="button" id="addBtnServiceUf" class="waves-effect #1565c0 blue darken-3 btn" value="addbtnsvruf">
                            Créer un service / unité fonctionnelle
                        </button>
                    </div>
                    <div id="addServiceUf">
                        <?php
                        if (count($services) > 0) {
                            $i_uf = 0;
                            foreach ($services as $service) {
                                $unitefonctionnelles = array();
                                if (isset($service['code']) && !empty($service['code'])) {
                                    $unitefonctionnelles = getUniteFonctionnelles($service['id']);
                                }
                                foreach ($unitefonctionnelles as $unitefonctionnelle) {
                                    ?>
                                    <div class="row" id="svr_uf<?php echo $i_uf; ?>">
                                        <div class="input-field col s4">
                                            <i class="material-icons prefix">business</i>
                                            <input placeholder="service" id="libelleService_<?php echo $i_uf; ?>" type="text" name="libelleService_<?php echo $i_uf; ?>" value="<?php echo $service['libelle']; ?>" />
                                        </div>
                                        <div class="input-field col s4">
                                            <input placeholder="unite fonctionnelle" id="libelleUf_<?php echo $i_uf; ?>" type="text" name="libelleUf_<?php echo $i_uf; ?>" value="<?php echo $unitefonctionnelle['libelle']; ?>" />
                                        </div>
                                        <div class='input-field col s4' onclick='removeHtml(svr_uf<?php echo $i_uf; ?>)'>
                                            <i class='material-icons prefix' style='cursor:pointer;'>delete</i>
                                        </div>
                                    </div>
                        <?php
                                    $i_uf = $i_uf + 1;
                                }
                            }
                        }
                        ?>
                    </div>
                    <input id="code" type="hidden" name="code" value="<?php echo $_GET['code']; ?>" />
                    <input id="codeSite" type="hidden" name="codeSite" value="<?php echo $_GET['codeSite']; ?>" />
                    <input id="idSite" type="hidden" name="idSite" value="<?php echo $site->id; ?>" />
                    <div class="section center">
                        <a class="btn waves-effect waves-light #00bfa5 teal accent-4" href="index.php?code=<?php echo $_GET['code']; ?>">
                            RETOUR
                        </a>
                        &nbsp;&nbsp;
                        <button type="submit" class="waves-effect #1565c0 blue darken-3 btn">
                            Enregistrer les données
                        </button>
                        <?php
                        if (isset($site->id)) {
                            ?>
                            <button type="button" id="deleteSite" class="waves-effect #c62828 red darken-3 btn" value="<?php echo $site->id . ";" . $structure->code; ?>">
                                Supprimer
                            </button>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>