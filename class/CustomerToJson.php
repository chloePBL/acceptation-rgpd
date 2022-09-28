<?php
/* 
* Class CustomerToJson
* permet de convertir un objet Customer en fichier JSON
*/
class CustomerToJson implements ICustomerToJson
{
    // Déclaration des propriétés de la class
    private $oCust; // Objet Customer
    private $sJson; // fichier JSON
    private $sMsg; // message erreur
    
    /**
     * __construct function
     *
     * @param [OBJECT] $oCust
     */
    public function __construct($oCust)
    {
        $this->oCust = $oCust;
    }
    /**
     * implementJson function
     *
     * Méthode qui permet d'implémenter un ficher JSON avec les infos de l'objet Customer
     */
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
    /**
     * getJson function
     *
     * @return [STRING] $this->sJson
     */
    public function getJson()
    {
        return $this->sJson;
    }
    /**
     * getError function
     *
     * @return [STRING] $this->sMsg
     */
    public function getError()
    {
        return $this->sMsg;
    }
    /**
     * execute function
     *
     * @return [BOOLEAN] $bRet
     */
    public function execute()
    {
        $bRet = true;
        if ($this->implementJson() == false ){
            $bRet = false;
        }
        return $bRet;
    }
}