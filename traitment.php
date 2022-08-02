<?php
// Inclusion des interfaces
include("interfaces/Int.callWS.php");
include("interfaces/Int.customerToJson.php");

// Inclusion des class
include("class/class.customer.php");
include("class/class.customerToJson.php");
include("class/class.callWS.php");
include("view/view.header.php");
// Bouton de redirection sur le site BL
function btnRedir(){
    echo '<div class="btn-redi shadow-sm">
            <a href="https://www.bleulibellule.com/" class="lien-redi">
                Aller sur Bleu Libellule 
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                </svg>
            </a>
        </div>';
}
// Définition du fuseau horaire souhaité
date_default_timezone_set("Europe/Paris");
//Instanciation de la Class Customer avec l'objet customer
$oCustomer = new ClCustomer();
if (isset($_POST['code_customer'])) {
    $oCustomer->intCode_customer = $_POST['code_customer'];
    $oCustomer->sDateAccepted = date('Y-m-d H:i:s', time());
    if (!isset($_POST['opt_in_none'])) {
        //Verif si l'Opt-in Téléphone est coché
        if (isset($_POST['phone'])) {
            $oCustomer->isOptIn_phone = 1; 
        } else {
            $oCustomer->isOptIn_phone = 0;
        }
        //Verif si l'Opt-in SMS est coché
        if (isset($_POST['sms'])) {
            $oCustomer->isOptIn_sms = 1;
        } else {
            $oCustomer->isOptIn_sms = 0;
        }
        //Verif si l'Opt-in email est coché
        if (isset($_POST['email'])) {
            $oCustomer->isOptIn_email= 1;
        } else {
            $oCustomer->isOptIn_email = 0;
        }
        //Verif si l'Opt-in mail est coché
        if (isset($_POST['mail'])) {
            $oCustomer->isOptIn_mail = 1;
        } else {
            $oCustomer->isOptIn_mail = 0;
        }
    } else {
        $oCustomer->isOptIn_phone = 0;
        $oCustomer->isOptIn_mail = 0;
        $oCustomer->isOptIn_sms = 0;
        $oCustomer->isOptIn_email = 0;
    }
}

// Instanciation de la class TranslationToJson avec l'objet oTranslationToJson qui prend en paramètre l'objet oCustomer
$oTranslationToJson = new ClCustomerToJson($oCustomer);
//Vérif si le fichier json a bien été implémenter avec les nouvelles infos de l'objet Customer sinon on affiche le message d'erreur
if ($oTranslationToJson->execute() == true) {
    //Déclaration des variables pour l'appel au WS
    // $url = 'https://bleulibellule.clic-till.com/wsRest/1_4/wsServerCustomer/SetCustomer';
    // $token = 'Token: 372397pHyrmGhhY2Zkm5hmlmJr';
    $url = 'https://testbl.retailandco.org/wsRest/1_5/wsServerCustomer/SetCustomer';
    $token = 'Token: 645443ebCsm2lomJqWlmlqZ2aU';
    $method = 'POST';
    $sValue = $oTranslationToJson->getJson();
    // Appel au web service 
    $oCallWS = new ClCallWS($url, $token, $method);
    $bRetour = $oCallWS->execute($sValue);
    //Vérif si l'appel du WS SetCustomer c'est bien passé sinon affichage du message d'erreur
    if ($bRetour == true) {
        echo '<p class="text-traitment"><strong>Merci, nous avons bien pris en compte vos préférences de communication.</strong>';
        echo '<br><p>Si vous souhaitez modifier vos préférences de communication, rendez-vous dans votre espace MON COMPTE sur l’e-shop ou l’application.</p>';
        echo '<p class="text-traitment"><strong>À bientôt !</strong></p>';
    } else {
        echo '<p class="msg-erreur">' . $oCallWS->getError() . '</p>';
    }
} else {
    echo '<p class="msg-erreur">' . $oTranslationToJson->getError() . '</p>';
}
btnRedir();
include("view/view.footer.php");

