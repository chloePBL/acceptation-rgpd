<?php
// UTILITIES
require_once("../utilities/class.format-date.php");
require_once("../utilities/ut.date.php");
// Log
require_once "../utilities/interfaces/int.logger.php";
require_once("../utilities/ut.logFile.php");
$errorlog = new ClLogFile(null, "./logs/2", "RGPD-GET", new ClDate("Europe/Paris"));
$infolog = new ClLogFile(null, "./logs/1", "RGPD-GET", new ClDate("Europe/Paris"));
// Inclusion des interfaces
include("interfaces/Int.callWS.php");
include("interfaces/Int.customerFromJson.php");

// Inclusion des class
include("class/class.callWS.php");
include("class/class.customerFromJson.php");
include("class/class.customer.php");
include("class/class.traduction.php");
include("view/view.header.php");

if(isset($_GET['lang'])){
    define("LANG", $_GET['lang']);
    $oTrad = new traduction($_GET['lang']);
}else{
    define("LANG", "EN");
    $oTrad = new traduction("EN");
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
/* echo '<form method="get" class="formLang">'
    . 'input type="hidden" name="code" value="' . KEY1 . '">'
    . 'input type="hidden" name="email" value="' . KEY2 . '">'
    . '<input type="image" name="lang" value="FR" class="imgLang" alt="Langue French" src="./assets/img/la-france.png">'
    . '<input type="image" name="lang" value="IT" class="imgLang" alt="Langue French" src="./assets/img/italie.png">'
    . '<input type="image" name="lang" value="EN" class="imgLang" alt="Langue French" src="./assets/img/royaume-uni.png">'
.'</form>'; */
//Vérification si les constantes ne sont pas vides avec la fonction empty
if (!empty(KEY1) & !empty(KEY2)){
    $infolog->addToLog(1, "[APPEL-WS-GET]-OK");
    //Déclaration des variables pour l'appel au WS
    //$url = 'https://bleulibellule.clic-till.com/wsRest/1_5/wsServerCustomer/GetCustomer';
    //$token = 'Token: 372397pHyrmGhhY2Zkm5hmlmJr';
    $url = 'https://testbl.retailandco.org/wsRest/1_5/wsServerCustomer/GetCustomer';
    $token = 'Token: 645443ebCsm2lomJqWlmlqZ2aU';
    $method = 'POST';
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
    $oCallWS = new ClCallWS($url, $token, $method);
    $bRetour = $oCallWS->execute($sValue);
    // le retour est OK ... on continue
    if ($bRetour == true) {
        $infolog->addToLog(1, "[APPEL-WS-GET]-OK");
        //Instanciation de la Class Customer
        $oCustomer = new ClCustomer();
        //Implémentation des infos récupéré dans le richier json dans l'obj oCustomer
        $oTranslationJson = new ClCustomerFromJson($oCallWS->getJson(), $oCustomer);
        // Vérif si le décodage du fichier Json c'est bien passé sinon affichage du message d'erreur
        if($oTranslationJson->execute() == true){
            $infolog->addToLog(1, "[TRANSLATION-JSON]-OK");
            //Vérification de l'email et du code client envoyé par splio est le même que celui dans le fichier json sinon exit()
            if (KEY2 === $oCustomer->sEmail && KEY1 === $oCustomer->intCode_customer){
                /* var_dump(md5($oCustomer->sEmail));
                var_dump(KEY2);
                var_dump(md5($oCustomer->sEmail) == KEY2); */
            //if ((md5($oCustomer->sEmail) ==  KEY2)  && KEY1 === $oCustomer->intCode_customer){
            //$passwordSha = hash("sha256", $oCustomer->sEmail);
            //echo("<br>47582711847d5e3539f1a18d49ba789f946d1a79a37fe6196159b7dd25a396bc");
            //var_dump($passwordSha);
            //var_dump(KEY1);
            //var_dump(KEY2);
            //var_dump($oCustomer->sEmail);
            //if ($passwordSha === KEY2 && KEY1 === $oCustomer->intCode_customer){
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
