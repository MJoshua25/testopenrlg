<?php
    session_start();
    require_once "../db/db_connect.php";
    require_once '../models/demande.model.php';
    require_once "../db/demandes.php";

    $demandefk = $_POST['demandefk'];    
    $listes = getLangueDemandeByCode($demandefk);
?>
<table>
    <thead>
        <th>Nom et prénoms</th>
        <th>others</th>       
    </thead>
    <tbody>
<?php
    $i=1;
    foreach($listes as $interprete){
?>
    <tr>        
        <td class="input-field">
            <label>                
                <input name="interpretefk" id="interpretefk<?php echo $i; ?>" type="radio" 
                        value="<?php echo $interprete['personnefk'];?>"/>
                <span><?php echo $interprete['nom']." ".$interprete['prenom']; ?></span>
            </label>
        </td>
        <td>others</td>
    </tr>        
<?php
        $i++;
    }
?>
    </tbody>
</table>