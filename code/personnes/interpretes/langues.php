<?php
require_once "../db/db_connect.php";
require_once '../db/langues.php';
$languesInt = getLanguesInterpreteByCode($_GET['prs']);
$langues = getLangues();
?>
<script type="text/javascript" language="javascript" class="init">
    $(document).ready(function() {
        $('#formLangue').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '../db/addlangueInterprete.php',
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
<div class="row">
    <div class="col s12">
        <div class="row" style="color: #1565c0; font-weight: bold;">
            <h5>Liste des langues</h5>
        </div>
        <table class="display" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Langues</th>
                    <th>Ecrite</th>
                    <th>Orale</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($languesInt as $langue) {
                    ?>
                    <tr>
                        <td><?php echo $langue->libelle; ?></td>
                        <td><?php echo $langue->langue_orale; ?></td>
                        <td><?php echo $langue->langue_ecrite; ?></td>
                        <td>
                            <a href="index.php?code=<?php echo $_GET['code']; ?>&prs=<?php echo $_GET['prs']; ?>&tpprs=int&lngint=<?php echo $langue->languefk ?>">
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
            <tfoot>
                <tr>
                    <th colspan="3"></th>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="col s12">
        <div class="row" style="color: #1565c0; font-weight: bold;">
            <h5>Ajouter une nouvelle langue</h5>
        </div>
        <div class="row">
            <form method="post" id="formLangue">
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
                                    <option value="<?php echo $langue['id']; ?>">
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
                                <input type="checkbox" name="orale" class="filled-in yellow"/><span>Orale</span>
                            </label>
                        </div>
                        <div class="input-field col s3">
                            <label>
                                <input type="checkbox" name="ecrite" class="filled-in"/><span>Ecrite</span>
                            </label>
                        </div>
                        <div class="input-field col s3">
                            <input id="personnefk" type="hidden" name="personnefk" value="<?php echo $_GET['prs']; ?>" />
                            <button type="submit" class="waves-effect #1565c0 blue darken-3 btn">
                                Enregistrer les données
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>