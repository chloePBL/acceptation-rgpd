<?php
class traduction
{
    private $lang;
    private $idRow;
    private $subject;
    private $obj;

    public function __construct($lang){
        $this->lang = $lang;
    }

    private function readJson($file)
    {
        $data = file_get_contents($file);
        $this->obj = json_decode($data);
    }

    public function trad($subject, $id)
    {
        switch($this->lang){
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
        }
    }
}