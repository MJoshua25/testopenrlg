<?php
session_start();
require_once "../header.php";
require_once "../db/db_connect.php";
require_once '../models/personne.model.php';
require_once "../db/personne.php";

$message = "";
if (isset($_POST['nom']) && isset($_POST['prenom'])) {
    $okGoEnregistre = true;
    // Vérifier le nom
    if (empty(isset($_POST['nom']))) {
        $message = "Le nom est obligatoire !";
        $okGoEnregistre = false;
    } else if (empty(isset($_POST['nom']))) {
        $message = "Le prenom est obligatoire !";
        $okGoEnregistre = false;
    } else if (empty($_POST['motdepasse']) || empty($_POST['motdepasseconf'])) {
        $message = "Le mot de passe ou la confirmation est obligatoire !";
        $okGoEnregistre = false;
    } else if ($_POST['motdepasse'] != $_POST['motdepasseconf']) {
        $message = "Le mot de passe doit être le même que la confirmation !";
        $okGoEnregistre = false;
    }

    // Enregister
    if ($okGoEnregistre) {
        $personneEng = new Personne();
        $personneEng->id = $_POST["personnefk"];
        $personneEng->email = $_SESSION['email'];
        $personneEng->nom = $_POST["nom"];
        $personneEng->prenom = $_POST["prenom"];
        $personneEng->date_modif_enr = strtotime(time());
        $personneEng->code_user_to_update = $_SESSION['email'];
        $personneEng->code_civilite = $_POST["civilite"];
        $personneEng->code_sexe = strval($_POST["sexe"]);
        $personneEng->motdepasse = $_POST["motdepasse"];

        // enregistrer les informations de la perosnne
        $reponse = enregistrerInfosCompte($personneEng,true);
        $message = $reponse[0];
        // Modifier l'info de la session
        $_SESSION['nom'] = $personneEng->nom;
        $_SESSION['prenom'] = $personneEng->prenom;
    }
}

$personne = getPersonneEmail($_SESSION['email']);
$idPers = $personne[0]["id"]; 
$email = $personne[0]["email"];
$nom = $personne[0]["nom"];
$prenom = $personne[0]["prenom"];
$date_modif_enr = $personne[0]["date_modif_enr"];
$code_user_to_update = $personne[0]["code_user_to_update"];
$code_civilite = $personne[0]["code_civilite"];
$code_sexe = $personne[0]["code_sexe"];
$token_activation = $personne[0]["token_activation"];
$token_mdp = $personne[0]["token_mdp"];

?>
<div class="container">
    <h3>
        <img src="../assets/img/mon_compte.jpeg" style="width: 45px; height: 45px;" /> Gérer mon compte
    </h3>
    <br/>
    <a class="btn waves-effect waves-light #1565c0 blue darken-3" href="../index.php">
    < < < Retour
    </a>
    <br/>
    <br/>
    <form method="post">
        <?php
        if (!empty($message)) {
            ?>
            <div class="row">
                <h5 style="text-align: center; color: #ff6f00; font-weight: bold; ">
                    <?php echo $message; ?>
                </h5>
            </div>
        <?php
        }
        ?>
        <div class="row">
            <div class="col s8 offset-s2">
                <div class="card-panel">
                    <br />
                    <div class="row">
                        <div class="input-field col s6">
                            <i class="material-icons prefix">person</i>
                            <select name="civilite">
                                <option value=""></option>
                                <option value="M." <?php if ($code_civilite == "M.") echo " selected"; ?>>M.</option>
                                <option value="Mme" <?php if ($code_civilite == "Mme") echo " selected"; ?>>Mme</option>
                                <option value="Mlle" <?php if ($code_civilite == "Mlle") echo " selected"; ?>>Mlle</option>
                            </select>
                            <label for="civilite">Civilité</label>
                        </div>

                        <div class="input-field col s6">
                            <i class="material-icons prefix">people</i>
                            <select name="sexe">
                                <option value=""></option>
                                <option value="1" <?php if ($code_sexe == "1") echo " selected"; ?>>Masculin</option>
                                <option value="2" <?php if ($code_sexe == "2") echo " selected"; ?>>Féminin</option>
                            </select>
                            <label>Sexe</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s6">
                            <i class="material-icons prefix">account_circle</i>
                            <input placeholder="Nom" id="nom" type="text" class="active validate" name="nom" value="<?php echo $nom; ?>" />
                            <label for="name">Nom</label>
                        </div>
                        <div class="input-field col s6">
                            <i class="material-icons prefix">account_circle</i>
                            <input id="prenom" type="text" placeholder="Prenom" class="validate" name="prenom" value="<?php echo $prenom; ?>" />
                            <label for="prenom">Prenom</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s6">
                            <i class="material-icons prefix">security</i>
                            <input placeholder="Mot de passe" id="motdepasse" type="password" class="active validate" name="motdepasse" required value="" />
                            <label for="motdepasse">Mot de passe</label>
                        </div>

                        <div class="input-field col s6">
                            <i class="material-icons prefix">security</i>
                            <input id="motdepasseconf" type="password" placeholder="Confirmation du mot de passe" class="validate" name="motdepasseconf" value="" />
                            <label for="motdepasseconf">Confirmer le mot de passe</label>
                        </div>
                    </div>
                    <div class="section center">
                        <input id="personnefk" type="hidden" name="personnefk" value="<?php echo $idPers; ?>" />
                        <input id="token_activation" type="hidden" name="token_activation" value="<?php echo $token_activation; ?>" />
                        <input id="token_mdp" type="hidden" name="token_mdp" value="<?php echo $token_mdp; ?>" />
                        <!--
                        <a class="btn waves-effect waves-light #1565c0 blue darken-3" href="../index.php">
                            RETOUR
                        </a>
                        -->
                        <button type="submit" class="waves-effect #1565c0 blue darken-3 btn">
                            Enregistrer les données
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<?php
//require_once "../footer.php";
?>