<?php
    require_once "../db/db_connect.php";
    require_once '../models/structure.model.php';
    require_once '../models/site.model.php';
    require_once '../models/service.model.php';
    require_once '../models/unitefonctionnelle.model.php';
    require_once "../db/structures.php";
    require_once "../db/sites.php";
    require_once "../db/services.php";
    require_once "../db/unitefonctionnelles.php";

    $message_erreur = array();
    $codeSite = $_POST['codeSite'];
    $code = $_POST['code'];
    $structure = getStructureByCode($code);
    // Vérification des infos
    // libelle de la structure        
    if (empty($_POST['libelleSite'])) {
        $message_erreur[] = "le libellé du site";
    }
    // adresse du site       
    if (empty($_POST['adresseSite'])) {
        $message_erreur[] = "l'adresse du site";
    }
    // code postal du site        
    if (empty($_POST['codePostalSite'])) {
        $message_erreur[] = "le code postal du site";
    }
    // libelle de la structure     
    if (empty($_POST['villeSite'])) {
        $message_erreur[] = "la ville du site";
    }

    // S'il n'y pas de message d'erreur
    $idSiteEnr = "";
    if (isset($_POST['idSite']) && !empty($_POST['idSite'])) {
        $idSiteEnr = $_POST['idSite'];
    }
    $site = getSiteByInfos(
        $idSiteEnr,
        $codeSite,
        $_POST['libelleSite'],
        $_POST['adresseSite'],
        $_POST['codePostalSite'],
        $_POST['villeSite'],
        $structure->id
    );
    $services = getServices($site->id);   
    $tabService = array();
    if (empty($message_erreur)) {
        $flagEng = true;
        if ($codeSite == 'vide') {
            $flagEng = false;
        }        
        // Enregistrer les services et UF              
        for($i=0; $i<9; $i++){                       
            if(isset($_POST['libelleService_'.$i]) && isset($_POST['libelleUf_'.$i])){                
                $libServe = $_POST['libelleService_'.$i];
                $libUf = $_POST['libelleUf_'.$i];
                if(empty($libServe) || empty($libUf)){
                    $message_erreur[] = "libellé service ou uf obligatoire !!!";
                } else {
                    $tabService[$libServe] = $libUf;                    
                }
            }
        }
        if(empty($message_erreur)){
            $response = enregistrerSite($site, $flagEng);
            $sitefk = $response[1];            
            // Enregistrer les services            
            foreach($tabService as $serviceLibelle=>$ufLibelle){                               
                // Enregistrer service
                $servicefk = 0;
                $service = new Service();
                $service->sitefk = $sitefk;
                $service->libelle = $serviceLibelle;
                $enrNewServe = true;                   
                if(!isServiceExiste($serviceLibelle, $sitefk)>0){
                    $enrNewServe = false;
                }
                $responseService =enregistrerService($service,$enrNewServe);
                $servicefk = $responseService[1];

                // Enregistrement UF
                $uf = new Unitefonctionnelle();
                $uf->libelle = $ufLibelle;
                $uf->servicefk = $servicefk;
                $enrNewUf = true;              
                if(!isUfExiste($ufLibelle,$servicefk)){                                      
                    $enrNewUf = false;                    
                }
                enregistrerUf($uf,$enrNewUf);
            }
            // Mettre à jour le type de structure
            $structure->typestructure = "HOPITAUX";
            enregistrerStructure($structure, true);
            $message_succes = $response[0];
            // Supprimer les services qui n'existe plus
            foreach($services as $serviceSup){
                if(array_key_exists ($serviceSup['libelle'],$tabService)){
                    removeService($serviceSup['id']);
                }
            }  
        }      
    }
    
    if(!empty($message_erreur)>0){
        $message_succes = "Tous les champs sont obligatoires, pas d'enregistrement !!!";        
    }       
    echo $message_succes;
	exit;
?>