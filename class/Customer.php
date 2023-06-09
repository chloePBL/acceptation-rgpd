<?php
/**
 * class Customer
 * Permet de créer un client avec les attributs initier
 */
class Customer
{
    // déclaration des propriétés de la class
    public $intCode_customer; // INT - contient le code Clic Till du client
    public $isOptIn_phone; // BOOL - prend comme valeur 0 ou 1 si le client a choisi d'être contacté par téléphone, 0 étant NON et 1 étant OUI
    public $isOptIn_sms; // BOOL - prend comme valeur 0 ou 1 si le client a choisi d'être contacté par sms, 0 étant NON et 1 étant OUI
    public $isOptIn_email; // BOOL - prend comme valeur 0 ou 1 si le client a choisi d'être contacté par email, 0 étant NON et 1 étant OUI
    public $isOptIn_mail; // BOOL - prend comme valeur 0 ou 1 si le client a choisi d'être contacté par mail, 0 étant NON et 1 étant OUI
    public $sEmail; // STRING - prend comme valeur l'adresse email du client dans une chaine de caractère
    public $sDateAccepted; // STRING - prend comme valeur la date de l'acceptation des RGPD

    public function __construct()
    {
        $this->intCode_customer = 0;
        $this->isOptIn_phone = 0;
        $this->isOptIn_sms = 0;
        $this->isOptIn_email = 0;
        $this->isOptIn_mail = 0;
        $this->sDateAccepted = "0000-00-00 00:00:00";
        $this->sEmail = "";
    }
}