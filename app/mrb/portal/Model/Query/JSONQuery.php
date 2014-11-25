<?php
/**
 * Created by PhpStorm.
 * User: akbar
 * Date: 17.11.14
 * Time: 15:51
 */

namespace mrb\portal\Model\Query;

class JSONQuery
{

    private $JSONFile;

    public function __construct(){
        $this->pathJSON = $_SERVER['DOCUMENT_ROOT'] . '/../public/lib/bungalau/';
    }

    public function setFileName($fileName){
        $this->JSONFile = $this->pathJSON.$fileName.'.json';
    }

    public function getAllDataFromJSON(){
        return json_decode(file_get_contents($this->JSONFile), true);
    }

    public function getSpesificDataFromJSON($week){
        $arrJSONData = array_reverse($this->getAllDataFromJSON(), true);
        $newJSONData = [];

        $i = 0;
        foreach($arrJSONData as $key=>$value){
            if($i<=$week){
                $newJSONData[$key] = $value;
                $i++;
            } else{
                break;
            }
        }
        return $newJSONData;
    }

    public function writeDataToJSON($data){
        file_put_contents($this->JSONFile, json_encode($data));
    }

    public function createJSONFile(){
        fopen($this->JSONFile, 'w');
        file_put_contents($this->JSONFile, '{}');
    }

    public function isJSONExsist(){
        if(file_exists($this->JSONFile)){
            return true;
        }
        return false;
    }
}