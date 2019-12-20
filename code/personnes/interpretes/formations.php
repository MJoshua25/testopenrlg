<?php
require_once "../db/db_connect.php";
require_once '../db/formations.php';
require_once '../utils/personnes.utils.php';
$typeFormation = getTypeFormation();
$formations = getFormations($_GET['prs'], $typeFormation);
?>
<script type="text/javascript" language="javascript" class="init">
    $(document).ready(function() {
        $('#formFormation').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '../db/addformation.php',
                data: $('#formFormation').serialize(),
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
                    <th>Date de formation</th>
                    <th>Sujet</th>
                    <th>Type formation</th>
                    <th>Analyse formation</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($formations as $formation) {
                    ?>
                    <tr>
                        <td><?php echo date("d/m/Y", strtotime($formation['date_formation'])); ?></td>
                        <td><?php echo $formation['sujet']; ?></td>
                        <td><?php echo $formation['type_formation']; ?></td>
                        <td><?php echo $formation['analyse_formation']; ?></td>                        
                        <td>
                            <a href="index.php?code=<?php echo $_GET['code']; ?>&prs=<?php echo $_GET['prs']; ?>&tpprs=int&frt=<?php echo $formation['id']?>">
                                <button type="submit" class="btn-floating btn waves-effect waves-light blue">
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
            <h5>Ajouter une nouvelle formation</h5>
        </div>
        <div class="row">
            <form method="post" id="formFormation">
                <div class="row">
                    <nav class="nav_form">
                        <div class="nav-wrapper textentete #1565c0 blue darken-3"></div>
                    </nav>
                    <br />
                    <div class="row">
                        <div class="input-field col s3">
                            <input id="date_formation" type="date" placeholder="Date de formation" name="date_formation" />
                            <label for="date_formation">Date de formation</label>
                        </div>
                        <div class="input-field col s3">
                            <input id="sujet" type="text" placeholder="Sujet" name="sujet" />
                            <label for="sujet">Sujet</label>
                        </div>
                        <div class="input-field col s3">
                            <select name="type_formation">
                                <option value=""></option>
                                <?php
                                foreach ($typeFormation as $key => $tformation) {
                                    ?>
                                    <option value="<?php echo $key; ?>">
                                        <?php echo $tformation; ?>
                                    </option>
                                <?php
                                }
                                ?>
                            </select>
                            <label for="typecontrat">Type de format<ion</label> </div> <div class="input-field col s3">
                                    <input id="analyse_formation" type="text" placeholder="Analyse de la formation" name="analyse_formation" />
                                    <label for="analyse_formation">Analyse de la formation</label>
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