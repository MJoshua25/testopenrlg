<?php
require_once "../db/db_connect.php";
require_once '../db/contrats.php';
require_once '../utils/personnes.utils.php';
$typePeriodicite = getTypePeriodicite();
$typeContrat = getTypeContrat();
$contrats = getContrats($_GET['prs'], $typeContrat, $typePeriodicite, false);
?>
<script type="text/javascript" language="javascript" class="init">    
    $(document).ready(function() {
        $('#formContrat').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '../db/addcontrat.php',
                data: $('#formContrat').serialize(),
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
<div class="row">
    <div class="col s12">
        <div class="row" style="color: #1565c0; font-weight: bold;">
            <h5>Liste des contrats</h5>
        </div>
        <table class="display" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Date du contrat</th>
                    <th>Type de contrat</th>
                    <th>Date medecin travail</th>
                    <th>Date entretien</th>
                    <th>nombre d'heures</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($contrats as $contrat) {
                    $date_contrat = $contrat['date_contrat'];
                    $date_entretien = $contrat['date_entretien'];
                    // date_contrat
                    if ($date_contrat != "0000-00-00 00:00:00") {
                        $date_contrat = date("d/m/Y", strtotime($date_contrat));
                    } else {
                        $date_contrat = "";
                    }
                    // date_medecin_travail
                    $date_medecin_travail = $contrat['date_medecin_travail'];
                    if ($date_medecin_travail != "0000-00-00 00:00:00") {
                        $date_medecin_travail = date("d/m/Y", strtotime($date_medecin_travail));
                    } else {
                        $date_medecin_travail = "";
                    }
                    // date_entretien
                    $date_entretien = $contrat['date_entretien'];
                    if ($date_entretien != "0000-00-00 00:00:00") {
                        $date_entretien = date("d/m/Y", strtotime($date_entretien));
                    } else {
                        $date_entretien = "";
                    }
                    ?>
                    <tr id="trctdel<?php echo $contrat['id']; ?>">
                        <td><?php echo $date_contrat; ?></td>
                        <td><?php echo $contrat['typecontrat']; ?></td>
                        <td><?php echo $date_medecin_travail; ?></td>
                        <td><?php echo $date_entretien; ?></td>
                        <td><?php echo $contrat['nb_heures']; ?>h / <?php echo $contrat['periodicite']; ?></td>
                        <td>
                            <a href="index.php?code=<?php echo $_GET['code']; ?>&prs=<?php echo $_GET['prs']; ?>&tpprs=int&crt=<?php echo $contrat['id']?>">
                                <button class="btn-floating btn waves-effect waves-light blue">
                                    <i class="material-icons prefix">update</i>
                                </button>
                            </a>
                        </td>                        
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>    
    <div class="col s12">
        <div class="row" style="color: #1565c0; font-weight: bold;">
            <h5>Ajouter un nouveau contrat</h5>
        </div>
        <div class="row">
            <form method="post" id="formContrat">
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
                                    <option value="<?php echo $key; ?>"><?php echo $tcontrat; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            <label for="typecontrat">Type de contrat</label>
                        </div>
                        <div class="input-field col s3">
                            <input id="date_contrat" type="date" placeholder="Date du contrat" name="date_contrat" />
                            <label for="date_contrat">Date du contrat</label>
                        </div>
                        <div class="input-field col s3">
                            <input id="nb_heures" type="text" placeholder="Nombre d'heures" name="nb_heures" />
                            <label for="nb_heures">Nombre d'heures</label>
                        </div>
                        <div class="input-field col s3">
                            <select name="type_periodicite">
                                <option value=""></option>
                                <?php
                                foreach ($typePeriodicite as $key => $tperiode) {
                                ?>
                                    <option value="<?php echo $key; ?>">
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
                            <input id="date_medecin_travail" type="date" placeholder="Médecine du travail" name="date_medecin_travail" />
                            <label for="date_medecin_travail">Médecine du travail</label>
                        </div>
                        <div class="input-field col s3">
                            <input id="entretien_individuel" type="date" placeholder="Entretien individuel" name="entretien_individuel" />
                            <label for="entretien_individuel">Entretien individuel</label>
                        </div>
                        <div class="input-field col s6">
                            <input id="entretien_stagiaire" type="text" placeholder="Entretien avec stagiaire" name="entretien_stagiaire" />
                            <label for="entretien_stagiaire">Entretien avec stagiaire</label>
                        </div>
                    </div>
                    <div class="section center">
                        <input id="personnefk" type="hidden" name="personnefk" value="<?php echo $_GET['prs']; ?>" />
                        &nbsp;&nbsp;
                        <button type="submit" class="waves-effect #1565c0 blue darken-3 btn">
                            Enregistrer les données
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>