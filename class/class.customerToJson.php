<?php
/* 
* Class ClCustomerToJson
* permet de convertir un objet Customer en fichier JSON
*/
class ClCustomerToJson implements ICustomerToJson
{
    // Déclaration des propriétés de la class
    private $oCust; // Objet Customer
    private $sJson; // fichier JSON
    private $sMsg; // message erreur
    
    // Déclaration du constructeur
    public function __construct($oCust)
    {
        $this->oCust = $oCust;
    }
    // Méthode qui permet d'implémenter un ficher JSON avec les infos de l'objet Customer
    private function implementJson()
    {
        // Init propriétés
        $bReturn = true;
        $sMsg = "";
        // Gestion des erreurs
        try {
            $this->sJson = '{"Customers":
                [
                    {
                        "mode": "U",
                        "code": "' . $this->oCust->intCode_customer . '",
                        "opt_in_phone": "' . $this->oCust->isOptIn_phone . '",
                        "phone_accepted_date": "' . $this->oCust->sDateAccepted . '",
                        "opt_in_sms": "' . $this->oCust->isOptIn_sms . '",
                        "sms_accepted_date": "' . $this->oCust->sDateAccepted . '",
                        "opt_in_email": "' . $this->oCust->isOptIn_email . '",
                        "email_accepted_date": "' . $this->oCust->sDateAccepted . '",
                        "opt_in_mail": "' . $this->oCust->isOptIn_mail . '",
                        "mail_accepted_date": "' . $this->oCust->sDateAccepted . '"
                    }
                ]
            }';
        } catch(Exception $e){
            $bReturn = false;
            $this->sMsg = $e;
        }
        return $bReturn;
    }
    // Retourne un fichier JSON
    public function getJson()
    {
        return $this->sJson;
    }
    // Retourne un messsage d'erreur
    public function getError()
    {
        return $this->sMsg;
    }
    // Execute la méthode d'implémentation du fichier JSON
    public function execute()
    {
        $bRet = true;
        if ($this->implementJson() == false ){
            $bRet = false;
        }
        return $bRet;
    }
}