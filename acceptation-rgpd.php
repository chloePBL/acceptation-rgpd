<?php
// Inclusion des interfaces
include("interfaces/Int.callWS.php");
include("interfaces/Int.customerFromJson.php");

// Inclusion des class
include("class/class.callWS.php");
include("class/class.customerFromJson.php");
include("class/class.customer.php");
include("view/view.header.php");
// Vérif si les valeurs sont bien passé dans l'url avec la fonction isset
// Déclaration des deux constantes KEY1 et KEY2 qui récupère les infos de la globale $_GET sinon la constante est vide
if (isset($_GET['code'])) { 
    define('KEY1', $_GET['code']);} 
else { 
    define('KEY1', ''); }
if (isset($_GET['email'])) { 
    define('KEY2', $_GET['email']);} 
else { 
    define('KEY2', ''); }
//Vérification si les constantes ne sont pas vides avec la fonction empty
if (!empty(KEY1) & !empty(KEY2)){
    //Déclaration des variables pour l'appel au WS
    // $url = 'https://bleulibellule.clic-till.com/wsRest/1_5/wsServerCustomer/GetCustomer';
    // $token = 'Token: 372397pHyrmGhhY2Zkm5hmlmJr';
    $url = 'https://testbl.retailandco.org/wsRest/1_5/wsServerCustomer/GetCustomer';
    $token = 'Token: 407910dYJ8mmZiamlnaGVsZGVr';
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
        //Instanciation de la Class Customer
        $oCustomer = new ClCustomer();
        //Implémentation des infos récupéré dans le richier json dans l'obj oCustomer
        $oTranslationJson = new ClCustomerFromJson($oCallWS->getJson(), $oCustomer);
        // Vérif si le décodage du fichier Json c'est bien passé sinon affichage du message d'erreur
        if($oTranslationJson->execute() == true){
            //Vérification de l'email et du code client envoyé par splio est le même que celui dans le fichier json sinon exit()
            if (KEY2 === $oCustomer->sEmail && KEY1 === $oCustomer->intCode_customer){
                //Affichage du formulaire pré-rempli en fonction des choix du client
                include("view/view.form.php");
            } else {
                echo '<p>l\'email et le code CT ne correspondent pas</p>';
                echo '<div class="btn-redi shadow-sm"><a href="https://www.bleulibellule.com/" class="lien-redi">Site Bleu Libellule</a></div>';
            }
        }else {
            echo '<p class="msg-erreur">' . $oTranslationJson->getError() . '</p>';
            echo '<div class="btn-redi shadow-sm"><a href="https://www.bleulibellule.com/" class="lien-redi">Site Bleu Libellule</a></div>';
        }
    } else {
        echo '<p class="msg-erreur">' . $oCallWS->getError() . '</p>';
        echo '<div class="btn-redi shadow-sm"><a href="https://www.bleulibellule.com/" class="lien-redi">Site Bleu Libellule</a></div>';
    }
} else { 
    // Si les constantes sont vides, affichage message d'erreur et exit()
    if (empty(KEY1) & empty(KEY2)){
        // Message erreur "Les deux clés sont vides"
        echo '<p class="msg-erreur">Sorry, veuillez renseigner un code et un mail</p>';
        echo '<div class="btn-redi shadow-sm"><a href="https://www.bleulibellule.com/" class="lien-redi">Site Bleu Libellule</a></div>';
    } else if (empty(KEY2)) {
        // Message erreur "la clé 2 est vide"
        echo '<p class="msg-erreur">Sorry, veuillez renseigner un mail</p>';
        echo '<div class="btn-redi shadow-sm"><a href="https://www.bleulibellule.com/" class="lien-redi">Site Bleu Libellule</a></div>';
    } else if (empty(KEY1)) {
        // Message erreur "la clé 1 est vide"
        echo '<p class="msg-erreur">Sorry, veuillez renseigner un code</p>';
        echo '<div class="btn-redi shadow-sm"><a href="https://www.bleulibellule.com/" class="lien-redi">Site Bleu Libellule</a>/div>';
    }
}
include("view/view.footer.php");
