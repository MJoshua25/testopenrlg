<script type="text/javascript" language="javascript" class="init">
    $(document).ready(function() {
        $(".tabs").tabs();
    });
</script>
<br/>
<div class="row">
    <div class="col s12">
        <ul class="tabs">
            <li class="tab col s2"><a href="#identitetabs">Identité</a></li>
            <?php
            if($_GET['code'] != 'vide'){
            ?>
            <li class="tab col s2"><a href="#languetabs">Langues</a></li>
            <li class="tab col s2"><a href="#contrattabs">Contrats</a></li>
            <li class="tab col s2"><a href="#formationtabs">Formations</a></li>
            <li class="tab col s2"><a href="#documenttabs">Documents</a></li>
            <li class="tab col s2"><a href="#interventiontabs">Interventions</a></li>
            <?php
            }
            ?>        
        </ul>
    </div>
    <div id="identitetabs" class="col s12">
        <?php require_once "identite.php"; ?>
    </div>
    <?php
        if($_GET['code'] != 'vide'){
    ?>
        <div id="languetabs" class="col s12">        
            <?php require_once "langues.php"; ?>
        </div>
        <div id="contrattabs" class="col s12">        
            <?php require_once "contrats.php"; ?>
        </div>
        <div id="formationtabs" class="col s12">
            <?php require_once "formations.php"; ?>
        </div>
        <div id="documenttabs" class="col s12">
            <?php require_once "documents.php"; ?>
        </div>
        <div id="interventiontabs" class="col s12">
            <?php require_once "interventions.php"; ?>
        </div>
    <?php
    }
    ?>   
</div>