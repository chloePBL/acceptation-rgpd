<?php
/* 
* Class CallWS
* permet d'appeler un web service
 */
class CallWS implements ICallWS
{
    // déclaration des propriétés
    private $sUrl; // STRING - prend comme valeur l'url de la ressource
    private $sToken; // STRING - prend comme valeur le jeton pour accéder à la ressource
    private $sJson; // STRING - prend comme valeur les infos clients dans JSON
    private $sMsg; // STRING - prend comme valeur le message d'erreur
    private $arData; // ARRAY - prend comme valeur un tableau avec les infos récupés par la session cURL
    private $sMethod; // STRING - prend comme valeur la méthod d'envoie http
    private $sJsonClone; // STRING - prend comme valeur une copie d'un objet

    // déclaration de la méthode construct
    public function __construct($sUrl, $sToken, $sMethod)
    {
        $this->sUrl = $sUrl;
        $this->sToken = $sToken;
        $this->sMethod = $sMethod;
    }
    /**
     * __clone function
     *
     * @return void
     */
    private function __clone()
    {
		$this->sJson = clone $this->sJson;
	}
    /**
     * callWS function
     *
     * @param [STRING] $sJsonExec
     * @return [BOOLEAN] $bReturn
     */
    private function callWS($sJsonExec)
    {
        // Initialisation
        $bReturn = true; 
        $sMsg = "";
        $curl = curl_init();
        // Gestion des erreurs
        try {
            curl_setopt_array($curl, array(
                CURLOPT_URL => $this->sUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => $this->sMethod,
                CURLOPT_POSTFIELDS => $sJsonExec,
                CURLOPT_HTTPHEADER => array('Content-Type: application/json', $this->sToken)
            ));
            // execution du WS
            $this->sJson = curl_exec($curl);
            $this->sJson = $this->sJson;
            // erreur dans le JSON
            if (curl_errno($curl)) {
                $bReturn = false;
                $this->sMsg = curl_error($curl);
            }
            else {
                // page pas OK (200)
                $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                if($http_code !== intval(200)){
                    $bReturn = false;
                    $this->sMsg = "Ressource introuvable : " . $http_code;
                }
            }
            return $bReturn;
        } catch (\Throwable $th) {
            throw $th;
        } finally {
            curl_close($curl); 
        }
    }
    /**
     * AnalyzeJson function
     *
     * @param [STRING] $retJsonWS
     * @return void
     */
    protected function AnalyzeJson($retJsonWS)
    {
        //initialisation
        $bReturn = true;
        $this->sMsg = "";
        // décodage du ficher JSON
        $this->arData = json_decode($retJsonWS, true);
        //Vérif si le code client cherché a été trouvé
        $sucessRowCount = $this->arData['response']['info']['success_rows_count'];
        //fichier trouvé
        if ($sucessRowCount == 1) {
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
     * execute function
     *
     * @param [STRING] $sJsonExecute
     * @return [BOOLEAN] $bRet
     */
    public function execute($sJsonExecute)
    {
        // initialisation
        $bRet = false;
        // appel WS
        $callVSRet = $this->callWS($sJsonExecute);
        // pas d'erreur
        if ($callVSRet == true){
            // appel analyse JSON si resultat OK
            $analyzeRet = $this->AnalyzeJson($this->sJson);
            // tout est OK
            if ($analyzeRet == true) {
                    $bRet = true;
                }
        } 
        return $bRet;
    }
    /**
     * getJson function
     *
     * @return [ARRAY] $this->arData
     */
    public function getJson()
    {
        return $this->arData['response']['data'][0];
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