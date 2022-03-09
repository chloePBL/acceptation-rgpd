<?php
/**
 * Class CLCustomerFromJson
 * permet de décoder le fichier JSON et d'implémenter les infos recueillis dans l'objet Customer
 */
class ClCustomerFromJson implements ICustomerFromJson
{
    // Déclaration des propriétés
    private $sMsg; // STRING - message d'erreur
    private $sDataJson; // STRING - fichier JSON
    private $oCustomer; // OBJET - objet customer

    // Déclaration du constructeur
    public function __construct($sDataJson, $oCustomer)
    {
        $this->sDataJson = $sDataJson;
        $this->oCustomer = $oCustomer;
    }
    // implémantation des infos clients dans l'objet customer via la méthode assignation
    private function assignation()
    {
        // Initialisation
        $bRet = true;
        $this->sMsg = "";
        // Gestion des erreurs
        try {
            // Implémentation des attributs de l'objet $customer avec les infos récupérés dans le JSON
            $this->oCustomer->intCode_customer = $this->sDataJson['code_customer'];
            $this->oCustomer->isOptIn_phone = $this->sDataJson['opt_in_phone'];
            $this->oCustomer->isOptIn_sms = $this->sDataJson['opt_in_sms'];
            $this->oCustomer->isOptIn_email = $this->sDataJson['opt_in_email'];
            $this->oCustomer->isOptIn_mail = $this->sDataJson['opt_in_mail'];
            $this->oCustomer->sEmail = $this->sDataJson['email'];
        }
        catch(Exception $e){
            $this->sMsg = $e->getMessage();
            $bRet = false;
        }
        return $bRet;
    }
    // Affichage message d'erreur
    public function getError()
    {
        return $this->sMsg;
    }
    // execution du programme
    public function execute()
    {
        $bRet = false;
        $assignationRet = $this->assignation();
        if ($assignationRet == true) {
            $bRet = true;
            return $bRet;
        } else {
            return $bRet;
        }
    }
}