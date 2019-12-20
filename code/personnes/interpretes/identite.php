<?php
// Récupérer les informations
require_once "../db/db_connect.php";
require_once '../models/interprete.model.php';
require_once '../models/document.model.php';
require_once '../models/langues.interprete.model.php';
require_once '../utils/email.utils.php';
require_once "../db/interpretes.php";
require_once "../db/documents.php";
require_once "../db/langues.php";

$code = $_GET['code'];
$message_erreur = array();
$message_succes = "";
$interprete = new Interprete();
$interprete->id = $code;
$documents = array();
$langues = array();
$dateNaissance = "";
$dateDebut = "";
$dateFin = "";

// Chargement des données de l'interprète
if (isset($_GET['code']) && !empty($code) && $code != 'vide') {
  $interprete = getInterpreteByCode($code);
  $dateNaissance = date("Y-m-d", strtotime($interprete->date_naissance));
  $dateDebut = date("Y-m-d", strtotime($interprete->date_debut));
  $dateFin = date("Y-m-d", strtotime($interprete->date_fin));

  // liste des douments
  $documents = getDocumentsByCode($interprete->personnefk);
  // liste des langues
  $langues = getLanguesInterpreteByCode($interprete->personnefk);
}
?>
<script type="text/javascript" language="javascript" class="init">
  let maxLangues = <?php echo count($langues); ?>;
  $(document).ready(function() {
    $('#formInterprete').on('submit', function(e) {
      e.preventDefault();
      $.ajax({
        type: 'POST',
        url: '../db/addinterprete.php',
        data: $('#formInterprete').serialize(),
        success: function(response) {
          $('#msgErrorSuccess').text(response);
          $('html').animate({
            scrollTop: 0
          }, 'speed');
          return false;
        }
      });
    });
    $('#addBtnLangueInt').click(function() {
      const html = addLangueDiv();
      $('#addLangueInt').append(html);
    });

    $('#deleteInterprete').click(function() {
      var deleteId = $('#personnefk').val();
      $msg = "Etes-vous certain de supprimer cette personne?";
      if (confirm($msg)) {
        $.ajax({
          url: '../db/removeinterprete.php',
          type: 'POST',
          data: {
            id: deleteId
          },
          success: function(response) {
            if (response == 1) {
              window.location.href = "index.php#interpretestabs";
            } else {
              alert("Problème lors de la suppression de l'interprète.");
            }
          }
        });
      }
    });
  });

  function addLangueDiv() {
    maxLangues += 1;
    var $html = "<div class='row' id='idlangue_" + maxLangues + "'>";
    $html += "<div class='input-field col s1'>";
    $html += "balise select";
    $html += "</div>";
    $html += "<div class='input-field col s1'>";
    $html += "<label>";
    $html += "<input type='checkbox' class='filled-in' />";
    $html += "<span>Ecrite</span>";
    $html += "</label>";
    $html += "</div>";
    $html += "<div class='input-field col s1'>";
    $html += "<label>";
    $html += "<input type='checkbox' class='filled-in yellow' />";
    $html += "<span>Orale</span>";
    $html += "</label>";
    $html += "</div>";
    $html += "</div>";

    return $html;
  }
</script>

<form enctype="multipart/form-data" method="post" id="formInterprete">
  <div class="row">
    <div class="col s12">
      <div class="row" style="color: #ff6f00; font-weight: bold;">
        <h5 id="msgErrorSuccess"></h5>
      </div>
      <div class="card-panel">
        <nav class="nav_form">
          <div class="nav-wrapper textentete #1565c0 blue darken-3" style="text-align: center;font-weight: bold;">
            Informations personnelles (Identité)
          </div>
        </nav>
        <br />
        <div class="row">
          <!-- Civilité -->
          <div class="input-field col s4">
            <i class="material-icons prefix">person</i>
            <select name="code_civilite">
              <option value=""></option>
              <option value="Mr" <?php if ($interprete->code_civilite == "Mr") echo " selected"; ?>>Mr</option>
              <option value="Mme" <?php if ($interprete->code_civilite == "Mme") echo " selected"; ?>>Mme</option>
              <option value="Mlle" <?php if ($interprete->code_civilite == "Mlle") echo " selected"; ?>>Mlle</option>
            </select>
            <label for="name">Civilité</label>
          </div>

          <!-- Sexe -->
          <div class="input-field col s4">
            <i class="material-icons prefix">people</i>
            <select name="code_sexe">
              <option value=""></option>
              <option value="1" <?php if ($interprete->code_sexe == "1") echo " selected"; ?>>Homme</option>
              <option value="2" <?php if ($interprete->code_sexe == "2") echo " selected"; ?>>Femme</option>
            </select>
            <label>Sexe</label>
          </div>

          <!-- Actif ou pas -->
          <div class="input-field col s4">
            <i class="material-icons prefix">account_circle</i>
            <select name="is_actif">
              <option value=""></option>
              <option value="1" <?php if ($interprete->is_actif == "1") echo " selected"; ?>>Oui</option>
              <option value="2" <?php if ($interprete->is_actif == "2") echo " selected"; ?>>Non</option>
            </select>
            <label for="name">Actif ou non?</label>
          </div>
        </div>
        <div class="row">
          <!-- Nom de naissance -->
          <div class="input-field col s4">
            <i class="material-icons prefix">account_circle</i>
            <input placeholder="Nom de naissance" id="nom_naissance" type="text" name="nom_naissance" value="<?php echo $interprete->nom_naissance; ?>" />
          </div>
          <!-- Nom marital -->
          <div class="input-field col s4">
            <i class="material-icons prefix">account_circle</i>
            <input placeholder="Nom marital" id="nom_marital" type="text" name="nom_marital" value="<?php echo $interprete->nom_marital; ?>" />
            <label for="name">Nom marital</label>
          </div>
          <!-- Prenom -->
          <div class="input-field col s4">
            <input id="prenom" type="text" placeholder="Prenom" name="prenom" value="<?php echo $interprete->prenoms; ?>" />
            <label for="name">Prenom</label>
          </div>
        </div>
        <nav class="nav_form">
          <div class="nav-wrapper textentete #1565c0 blue darken-3" style="text-align: center;font-weight: bold;">
            Administratif
          </div>
        </nav>
        <br />
        <div class="row">
          <!-- Date de naissance -->
          <div class="input-field col s4">
            <i class="material-icons prefix">date_range</i>
            <input id="date_naissance" type="date" placeholder="Date de sortie" value="<?php echo $dateNaissance; ?>" name="date_naissance" />
            <label for="name">Date de naissance</label>
          </div>
          <!-- Date d'entrée -->
          <div class="input-field col s4">
            <i class="material-icons prefix">date_range</i>
            <input id="	date_debut" type="date" placeholder="Date de début" value="<?php $dateDebut; ?>" name="date_debut" />
            <label for="name">Date d'arrivée</label>
          </div>
          <!-- Date de sortie -->
          <div class="input-field col s4">
            <i class="material-icons prefix">date_range</i>
            <input id="date_fin" type="date" placeholder="Date de sortie" value="<?php echo $dateFin; ?>" name="date_fin" />
            <label for="name">Date de sortie</label>
          </div>
        </div>
        <div class="row">
          <!-- Adresse -->
          <div class="input-field col s4">
            <i class="material-icons prefix">domain</i>
            <input placeholder="Adresse" id="adresse" type="text" name="adresse" value="<?php echo $interprete->adresse; ?>" />
            <label for="name">Adresse</label>
          </div>
          <!-- Ville -->
          <div class="input-field col s4">
            <input placeholder="Ville" id="ville" type="text" name="ville" value="<?php echo $interprete->ville; ?>" />
            <label for="name">Ville</label>
          </div>
          <!-- Code postal -->
          <div class="input-field col s4">
            <input id="code_postal" type="text" placeholder="Code postal" name="code_postal" value="<?php echo $interprete->code_postal; ?>" />
            <label for="name">Code postal</label>
          </div>
        </div>
        <div class="row">
          <!-- Diplôme -->
          <div class="input-field col s4">
            <i class="material-icons prefix">account_circle</i>
            <input id="diplome" type="text" placeholder="Diplôme" name="diplome" value="<?php echo $interprete->diplome; ?>" />
            <label for="name">Diplôme</label>
          </div>
          <!-- Numéro de sécurité sociale -->
          <div class="input-field col s4">
            <i class="material-icons prefix">assignment</i>
            <input placeholder="Numéro de sécurité sociale" id="num_sec_sociale" type="text" name="num_sec_sociale" value="<?php echo $interprete->num_sec_sociale; ?>" />
            <label for="name">Numéro de sécurité sociale</label>
          </div>
        </div>
        <div class="row">
          <!-- Diplôme -->
          <div class="input-field col s4">
            <i class="material-icons prefix">directions_car</i>
            <select name="permis_vehicule">
              <option value=""></option>
              <option value="1" <?php if ($interprete->permis_vehicule == "1") echo " selected"; ?>>Oui</option>
              <option value="2" <?php if ($interprete->permis_vehicule == "2") echo " selected"; ?>>Non</option>
            </select>
            <label for="name">Permis/Véhicule</label>
          </div>
          <!-- Nombre de chévaux fiscaux du véhicule -->
          <div class="input-field col s4 l2">
            <input id="ch_fisc_vehicule" type="text" name="ch_fisc_vehicule" value="<?php echo $interprete->ch_fisc_vehicule; ?>" placeholder="chévaux fiscaux" />
          </div>
        </div>
        <nav class="nav_form">
          <div class="nav-wrapper textentete #1565c0 blue darken-3" style="text-align: center;font-weight: bold;">
            Coordonnées numériques
          </div>
        </nav>
        <br />
        <div class="row">
          <!-- Email -->
          <div class="input-field col s4">
            <i class="material-icons prefix">email</i>
            <input placeholder="Email" id="email" type="text" name="email" value="<?php echo $interprete->email; ?>" />
          </div>
          <!-- Téléphone pro -->
          <div class="input-field col s4">
            <i class="material-icons prefix">phone</i>
            <input placeholder="Téléphone pro" id="tel_pro" type="text" name="tel_pro" value="<?php echo $interprete->tel_pro; ?>" />
          </div>
          <!-- Téléphone personnel -->
          <div class="input-field col s4">
            <i class="material-icons prefix">phone_iphone</i>
            <input id="tel_perso" type="text" placeholder="Téléphone personnel" name="tel_perso" value="<?php echo $interprete->tel_perso; ?>" />
          </div>
        </div>    
        <nav class="nav_form">
          <div class="nav-wrapper textentete #1565c0 blue darken-3" style="text-align: center;font-weight: bold;">
            &nbsp;&nbsp;
          </div>
        </nav>
        <br />
        <input id="idInterprete" type="hidden" name="idInterprete" value="<?php echo $interprete->id; ?>" />
        <input id="personnefk" type="hidden" name="personnefk" value="<?php echo $interprete->personnefk; ?>" />
        <div class="section center">
          <a class="btn waves-effect waves-light #00bfa5 teal accent-4" href="index.php#interpretestabs">
            RETOUR
          </a>
          &nbsp;&nbsp;
          <button type="submit" class="waves-effect #1565c0 blue darken-3 btn">
            Enregistrer les données
          </button>
          <?php
          if (isset($interprete->id) && $interprete->id != "vide") {
            ?>
            <button type="button" id="deleteInterprete" class="waves-effect #c62828 red darken-3 btn">
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