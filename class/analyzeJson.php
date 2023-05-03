<?php

class AnalyzeJson {

    private $sJson; // STRING - retour de l'appel ws
    private $oEmployee; // OBJECT - données d'un employé
    private $arData; // ARRAY - prend comme valeur un tableau avec les infos récupés par la session cURL

    public function __construct($retJson){
        $this->sJson = $retJson;
    }
    
    public function traitmentJson(){
        //initialisation
        $bReturn = true;
        $this->sMsg = "";
        // décodage du ficher JSON
        $this->arData = json_decode($this->sJson, true);
        //Vérif si le code client cherché a été trouvé
        $sucessRowCount = $this->arData['response']['info']['success_rows_count'];
        //fichier trouvé
        if ($sucessRowCount == 1) {
            $this->arData = $this->arData['response']['data'][0];
            return $bReturn;
        }
        else {
            if (empty($this->arData['response']['info']['message'][0]['msg'])) {
                $this->sMsg = "Aucune ligne n'a été trouvée.";
                
            } else {
                $this->sMsg = $this->arData['response']['info']['message'][0]['msg'];
            }
            $bReturn = false;
            return $bReturn;
        } 
    }

    /**
     * getJson function
     *
     * @return [ARRAY] $this->arData
     */
    public function getData()
    {
        return $this->arData;
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
}