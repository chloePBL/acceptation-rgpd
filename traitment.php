<?php
// Inclusion des interfaces
include("interfaces/Int.callWS.php");
include("interfaces/Int.customerToJson.php");

// Inclusion des class
include("class/class.customer.php");
include("class/class.customerToJson.php");
include("class/class.callWS.php");
include("view/view.header.php");
// Définition du fuseau horaire souhaité
date_default_timezone_set("Europe/Paris");
//Instanciation de la Class Customer avec l'objet customer
$oCustomer = new ClCustomer();
$oCustomer->intCode_customer = $_POST['code_customer'];
$oCustomer->sDateAccepted = date('Y-m-d H:i:s', time());
//Verif si l'Opt-in Téléphone est coché
if (isset($_POST['phone'])){
    $oCustomer->isOptIn_phone = 1; 
}else {
    $oCustomer->isOptIn_phone = 0;
}
//Verif si l'Opt-in SMS est coché
if (isset($_POST['sms'])){
    $oCustomer->isOptIn_sms = 1;
}else {
    $oCustomer->isOptIn_sms = 0;
}
//Verif si l'Opt-in email est coché
if (isset($_POST['email'])){
    $oCustomer->isOptIn_email= 1;
}else {
    $oCustomer->isOptIn_email = 0;
}
//Verif si l'Opt-in mail est coché
if (isset($_POST['mail'])){
    $oCustomer->isOptIn_mail = 1;
}else {
    $oCustomer->isOptIn_mail = 0;
}
// Instanciation de la class TranslationToJson avec l'objet oTranslationToJson qui prend en paramètre l'objet oCustomer
$oTranslationToJson = new ClCustomerToJson($oCustomer);
//Vérif si le fichier json a bien été implémenter avec les nouvelles infos de l'objet Customer sinon on affiche le message d'erreur
if ($oTranslationToJson->execute() == true) {
    //Déclaration des variables pour l'appel au WS
    // $url = 'https://bleulibellule.clic-till.com/wsRest/1_4/wsServerCustomer/SetCustomer';
    // $token = 'Token: 372397pHyrmGhhY2Zkm5hmlmJr';
    $url = 'https://testbl.retailandco.org/wsRest/1_5/wsServerCustomer/SetCustomer';
    $token = 'Token: 407910dYJ8mmZiamlnaGVsZGVr';
    $method = 'POST';
    $sValue = $oTranslationToJson->getJson();
    // Appel au web service 
    $oCallWS = new ClCallWS($url, $token, $method);
    $bRetour = $oCallWS->execute($sValue);
    //Vérif si l'appel du WS SetCustomer c'est bien passé sinon affichage du message d'erreur
    if ($bRetour == true) {
        echo '<p>Vos opt-In ont été mis à jour</p>';
        echo '<div class="btn-redi shadow-sm"><a href="https://www.bleulibellule.com/" class="lien-redi">Site Bleu Libellule</a></div>';
    } else {
        echo '<p class="msg-erreur">' . $oCallWS->getError() . '</p>';
        echo '<div class="btn-redi shadow-sm"><a href="https://www.bleulibellule.com/" class="lien-redi">Site Bleu Libellule</a></div>';
    }

} else {
    echo '<p class="msg-erreur">' . $oTranslationToJson->getError() . '</p>';
}
include("view/view.footer.php");

