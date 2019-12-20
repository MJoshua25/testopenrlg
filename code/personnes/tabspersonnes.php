<script type="text/javascript" language="javascript" class="init">
    $(document).ready(function() {
        $(".tabs").tabs();
    });
</script>
<br/>
<div class="container">
    <h3>
        <img src="../assets/img/patients.jpg" style="width: 45px; height: 45px;" /> Gestion des personnes
    </h3>
    <br />
    <a class="btn waves-effect waves-light #1565c0 blue darken-3" href="../index.php">
        < < < Retour
    </a>
    <br />
    <br />
    <div class="row">
        <div class="col s12">
            <ul class="tabs">
                <li class="tab col s3"><a href="#professionnelstabs">Professionnels</a></li>
                <li class="tab col s3"><a href="#interpretestabs">Interprètes</a></li>
            </ul>
        </div>
        <div id="professionnelstabs" class="col s12">
            <?php require_once "professionnels.php"; ?>
        </div>
        <div id="interpretestabs" class="col s12">
            <?php require_once "interpretes.php"; ?>
        </div>
    </div>
</div>