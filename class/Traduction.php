<?php
/**
 * Traduction class
 */
class Traduction
{
    private $lang;
    private $idRow;
    private $subject;
    private $obj;
    /**
     * __construct function
     *
     * @param [STRING] $lang
     */
    public function __construct($lang){
        $this->lang = $lang;
    }
    /**
     * readJson function
     *
     * @param [STRING] $file
     * @return void
     */
    private function readJson($file)
    {
        $data = file_get_contents($file);
        $this->obj = json_decode($data);
    }
    /**
     * trad function
     *
     * @param [STRING] $subject
     * @param [STRING] $id
     * @return [STRING] $this->obj
     */
    public function trad($subject, $id)
    {
        $lang = $this->lang;
        self::readJson("./assets/json/lang.json");
        
        if(isset($this->obj->lang->$lang)){
            self::readJson($this->obj->lang->$lang);
            return $this->obj->$subject->$id;
        }else{
            self::readJson($this->obj->lang->EN);
            return $this->obj->$subject->$id;
        }
        /* switch($this->lang){
            case "EN":
                self::readJson("./assets/json/english.json");
                return $this->obj->$subject->$id;
                break;
            case "FR":
                self::readJson("./assets/json/french.json");
                return $this->obj->$subject->$id;
            case "IT":
                self::readJson("./assets/json/italiano.json");
                return $this->obj->$subject->$id;
            default:
                self::readJson("./assets/json/english.json");
        } */
    }
}