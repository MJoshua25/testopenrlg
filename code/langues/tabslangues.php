<style type="text/css" class="init">
    td.details-control {
        background: url('../assets/img/details_open.png') no-repeat center center;
        cursor: pointer;
    }

    tr.shown td.details-control {
        background: url('../assets/img/details_close.png') no-repeat center center;
    }
</style>
<script type="text/javascript" language="javascript" class="init">
    $(document).ready(function() {
        $(".tabs").tabs();
    });
</script>
<br />
<div class="row container">
    <h3>
        <img src="../assets/img/langues.jpg" style="width: 45px; height: 45px;" /> Gestion des langues
    </h3>
    <br/>
    <a class="btn waves-effect waves-light #1565c0 blue darken-3" href="../index.php">
    < < < Retour
    </a>
    <br/>
    <br/> 
    <div class="row">
        <div class="col s12">
            <ul class="tabs">
                <li class="tab col s4"><a href="#languestabs">Langues</a></li>
                <li class="tab col s4"><a href="#lotslanguestabs">lots de langues</a></li>
                <li class="tab col s4"><a href="#marchestabs">Marché ou convention public</a></li>
            </ul>
        </div>
        <div id="languestabs" class="col s12">
            <?php require_once "langues.php"; ?>
        </div>
        <div id="lotslanguestabs" class="col s12">
            <?php require_once "lotslangues.php"; ?>
        </div>
        <div id="marchestabs" class="col s12">
            <?php require_once "marches.php"; ?>
        </div>
    </div>
</div>