<?php
// constantes d'accès
require_once("./class/config.php");
// UTILITIES
require("../utilities/autoloader_ut.php");
require('class/Autoloader.php');
// Autoloading des class/interfaces
Autoloader_ut::register();
Autoloader::register();

// Logs
$errorlog = new Log_file(null, "./logs/2", "RGPD-GET", new Date("Europe/Paris"));
$infolog = new Log_file(null, "./logs/1", "RGPD-GET", new Date("Europe/Paris"));

// VIEW
include("view/view.header.php");
// Affichage contenu en fonction de la lang passé en paramètre dans l'url
if(isset($_GET['lang']) && strlen($_GET['lang'])){
    define("LANG", $_GET['lang']);
    $oTrad = new Traduction(LANG);
}else{
    define("LANG", "EN");
    $oTrad = new Traduction(LANG);
}
function btnRedir($lang){
    switch($lang){
        case "FR":
            echo '<div class="btn-redi shadow-sm">
                    <a href="https://www.bleulibellule.com/" class="lien-redi">
                        Aller sur Bleu Libellule 
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                        </svg>
                    </a>
                </div>';
            break;
        case "IT":
            echo '<div class="btn-redi shadow-sm">
                    <a href="https://www.bleulibellule.it/" class="lien-redi">
                        Vai a Bleu Libellule 
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                        </svg>
                    </a>
                </div>';
            break;
        case "EN":
            echo '<div class="btn-redi shadow-sm">
                    <a href="https://www.bleulibellule.com/" class="lien-redi">
                        Go to Bleu Libellule 
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                        </svg>
                    </a>
                </div>';
            break;
        default:
            echo '<div class="btn-redi shadow-sm">
                    <a href="https://www.bleulibellule.com/" class="lien-redi">
                        Go to Bleu Libellule 
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                        </svg>
                    </a>
                </div>';
            break;

    }
}
echo '<div class="row marg-bot">'
    . '<h2>' . $oTrad->trad("home", "1")  . '</h2>'
    . '<p class="descriptionRGPD">' . $oTrad->trad("home", "2")   . '</p>'
. '</div>';
// Vérif si les valeurs sont bien passé dans l'url avec la fonction isset
// Déclaration des deux constantes KEY1 et KEY2 qui récupère les infos de la globale $_GET sinon la constante est vide
if (isset($_GET['code'])) { 
    //$code = $_GET['code'];
    //$code = substr($code,2); // supprimer CT devant le code 
    //define('KEY1', $code);
    define('KEY1', $_GET['code']);
    $infolog->addToLog(1, "[KEY1]-OK");
} 
else { 
    define('KEY1', '');
    $errorlog->addToLog(2, "[KEY1]-Pas de clé transmise");
}
if (isset($_GET['email'])) { 
    define('KEY2', $_GET['email']);
    $infolog->addToLog(1, "[KEY2]-OK");
} 
else { 
    define('KEY2', '');
    $errorlog->addToLog(2, "[KEY2]-Pas de clé transmise.");
}
echo '<form method="get" class="formLang">'
    . '<input type="hidden" name="code" value="' . KEY1 . '">'
    . '<input type="hidden" name="email" value="' . KEY2 . '">'
    . '<button type="submit" name="lang" value="FR" class="btnLang"><img src="./assets/img/la-france.png" class="imgLang" alt="Langue French"></button>'
    . '<button type="submit" name="lang" value="IT" class="btnLang"><img src="./assets/img/italie.png" class="imgLang" alt="Langue Italiano"></button>'
    . '<button type="submit" name="lang" value="EN" class="btnLang"><img src="./assets/img/royaume-uni.png" class="imgLang" alt="Langue English"></button>'
.'</form>';
//Vérification si les constantes ne sont pas vides avec la fonction empty
if (!empty(KEY1) & !empty(KEY2)){
    $infolog->addToLog(1, "[APPEL-WS-GET]-OK");
    
    $sValue = '{  
        "Customers":[  
          {  
            "codes" :
            [  
                {  
                  "code" : "' . KEY1 . '"
                }
            ]
          }
      ]
      }';
    // Appel du web service qui prend en paramètre l'url, le token et le client recherché
    $oCallWS = new CallWS(URL_GET_CUSTOMER, TOKEN, METHOD);
    $bRetour = $oCallWS->execute($sValue);
    // le retour est OK ... on continue
    if ($bRetour == true) {
        $infolog->addToLog(1, "[APPEL-WS-GET]-OK");

        // Analyse du json
        $oJson = new AnalyzeJson($oCallWS->getJson());
        $bRetAnalyze = $oJson->traitmentJson();
        if($bRetAnalyze == true){
            $infolog->addToLog(1, "[ANALYZE-JSON]- OK");
            //Instanciation de la Class Customer
            $oCustomer = new Customer();
            //Implémentation des infos récupéré dans le richier json dans l'obj oCustomer
            $oTranslationJson = new CustomerFromJson($oJson->getData(), $oCustomer);
            // Vérif si le décodage du fichier Json c'est bien passé sinon affichage du message d'erreur
            if($oTranslationJson->execute() == true){
                $infolog->addToLog(1, "[TRANSLATION-JSON]- OK");
                //Vérification de l'email et du code client envoyé par splio est le même que celui dans le fichier json sinon exit()
                if (KEY2 === $oCustomer->sEmail && KEY1 === $oCustomer->intCode_customer){
                    // Ajout log
                    $infolog->addToLog(1, "[CORRESPONDANCE-DONNEES]-client trouvé.");
                    //Affichage du formulaire pré-rempli en fonction des choix du client
                    include("view/view.form.php");
                } else {
                    $errorlog->addToLog(2, "[CORRESPONDANCE-DONNEES]-client introuvable.");
                    echo "<p>" . $oTrad->trad("error", "103") . "</p>";
                    btnRedir(LANG);
                }
            }else {
                $errorlog->addToLog(2, "[TRANSLATION-JSON]-" . $oTranslationJson->getError());
                echo "<p>" . $oTrad->trad("error", "101") . "</p>";
                btnRedir(LANG);
            }

        }else{
            $errorlog->addToLog(2, "[ANALYZE-JSON]-" . $oJson->getError());
            echo "<p>" . $oTrad->trad("error", "101") . "</p>";
            btnRedir(LANG);
        }
        
    } else {
        $errorlog->addToLog(2, "[APPEL-WS-GET]-" . $oCallWS->getError());
        echo "<p>" . $oTrad->trad("error", "101") . "</p>";
        btnRedir(LANG);
    }
} else { 
    // Si les constantes sont vides, affichage message d'erreur et exit()
    if (empty(KEY1) & empty(KEY2)){
        // Message erreur "Les deux clés sont vides"
        $errorlog->addToLog(2, "[LECTURE-URL]-Clés manquantes.");
    } else if (empty(KEY2) || empty(KEY1) ) {
        // Message erreur "la clé 2 est vide"
        $errorlog->addToLog(2, "[LECTURE-URL]-Une des deux clés manquantes.");
    }
    echo "<p>" . $oTrad->trad("error", "101") . "</p>";
    btnRedir(LANG);
}
include("view/view.footer.php");
