<?php
require 'class/autoloader.php';
Autoloader::register();
// UTILITIES
require_once("../utilities/class.format-date.php");
require_once("../utilities/ut.date.php");
// Log
require_once "../utilities/interfaces/int.logger.php";
require_once("../utilities/ut.logFile.php");
$errorlog = new ClLogFile(null, "./logs/2", "RGPD-GET", new ClDate("Europe/Paris"));
$infolog = new ClLogFile(null, "./logs/1", "RGPD-GET", new ClDate("Europe/Paris"));
// Inclusion des interfaces
require_once("interfaces/CallWS.php");
require_once("interfaces/CustomerToJson.php");
// View
include("view/view.header.php");
// Bouton de redirection sur le site BL
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
// Affichage contenu en fct de la lang
if(isset($_POST['lang'])){
    define("LANG", $_POST['lang']);
    $oTrad = new Traduction($_POST['lang']);
}else{
    define("LANG", "EN");
    $oTrad = new Traduction("EN");
}
// Définition du fuseau horaire souhaité
date_default_timezone_set("Europe/Paris");
//Instanciation de la Class Customer avec l'objet customer
$oCustomer = new Customer();
if (isset($_POST['code_customer'])) {
    $infolog->addToLog(1, "[RECUP-DONNEES]-code client récupéré");
    $oCustomer->intCode_customer = $_POST['code_customer'];
    $oCustomer->sDateAccepted = date('Y-m-d H:i:s', time());
    if (!isset($_POST['opt_in_none'])) {
        //Verif si l'Opt-in Téléphone est coché
        if (isset($_POST['phone'])) {
            $infolog->addToLog(1, "[OPTIN-PHONE]-coché");
            $oCustomer->isOptIn_phone = 1; 
        } else {
            $infolog->addToLog(1, "[OPTIN-PHONE]-pas coché");
            $oCustomer->isOptIn_phone = 0;
        }
        //Verif si l'Opt-in SMS est coché
        if (isset($_POST['sms'])) {
            $infolog->addToLog(1, "[OPTIN-SMS]-coché");
            $oCustomer->isOptIn_sms = 1;
        } else {
            $infolog->addToLog(1, "[OPTIN-SMS]-pas coché");
            $oCustomer->isOptIn_sms = 0;
        }
        //Verif si l'Opt-in email est coché
        if (isset($_POST['email'])) {
            $infolog->addToLog(1, "[OPTIN-EMAIL]-coché");
            $oCustomer->isOptIn_email= 1;
        } else {
            $infolog->addToLog(1, "[OPTIN-EMAIL]-pas coché");
            $oCustomer->isOptIn_email = 0;
        }
        //Verif si l'Opt-in mail est coché
        if (isset($_POST['mail'])) {
            $infolog->addToLog(1, "[OPTIN-MAIL]-coché");
            $oCustomer->isOptIn_mail = 1;
        } else {
            $infolog->addToLog(1, "[OPTIN-MAIL]-pas coché");
            $oCustomer->isOptIn_mail = 0;
        }
    } else {
        $infolog->addToLog(1, "[OPTIN-NONE]-coché");
        $oCustomer->isOptIn_phone = 0;
        $oCustomer->isOptIn_mail = 0;
        $oCustomer->isOptIn_sms = 0;
        $oCustomer->isOptIn_email = 0;
    }
}else {
    $errorlog->addToLog(2, "[RECUP-DONNEES]-Aucune donnée transmise");
}

// Instanciation de la class TranslationToJson avec l'objet oTranslationToJson qui prend en paramètre l'objet oCustomer
$oTranslationToJson = new CustomerToJson($oCustomer);
//Vérif si le fichier json a bien été implémenter avec les nouvelles infos de l'objet Customer sinon on affiche le message d'erreur
if ($oTranslationToJson->execute() == true) {
    $infolog->addToLog(1, "[TRANSLATE-JSON]-OK");
    //Déclaration des variables pour l'appel au WS
    // $url = 'https://bleulibellule.clic-till.com/wsRest/1_4/wsServerCustomer/SetCustomer';
    // $token = 'Token: 372397pHyrmGhhY2Zkm5hmlmJr';
    $url = 'https://testbl.retailandco.org/wsRest/1_5/wsServerCustomer/SetCustomer';
    $token = 'Token: 645443ebCsm2lomJqWlmlqZ2aU';
    $method = 'POST';
    $sValue = $oTranslationToJson->getJson();
    // Appel au web service 
    $oCallWS = new CallWS($url, $token, $method);
    $bRetour = $oCallWS->execute($sValue);
    //Vérif si l'appel du WS SetCustomer c'est bien passé sinon affichage du message d'erreur
    if ($bRetour == true) {
        $infolog->addToLog(1, "[APPEL-WS]-OK");
        echo '<p class="text-traitment"><strong>' . $oTrad->trad("traitment", "50")   . '</strong>';
        echo '<br><p>' . $oTrad->trad("traitment", "51")   . '</p>';
        echo '<p class="text-traitment"><strong>' . $oTrad->trad("traitment", "52")   . '</strong></p>';
    } else {
        echo '<p class="msg-erreur">' . $oTrad->trad("error", "102")   . '</p>';
        $errorlog->addToLog(2, "[APPEL-WS]-" . $oCallWS->getError());
    }
} else {
    echo '<p class="msg-erreur">' . $oTrad->trad("error", "102")   . '</p>';
    $errorlog->addToLog(2, "[TRANSLATE-JSON]-" . $oTranslationToJson->getError());
}
btnRedir(LANG);
include("view/view.footer.php");

