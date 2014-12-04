<?php
/**
 * Created by PhpStorm.
 * User: akbar
 * Date: 17.11.14
 * Time: 15:21
 */

namespace mrb\portal\Controller\Home;

use mrb\portal\Model\MRBModel;
use mrb\portal\Model\Query\JSONQuery;
use mrb\portal\Model\Query\MainQuery;

Class DashboardAction
{
    public function __construct(MRBModel $model) {
        $this->db = new MainQuery();
        $this->json = new JSONQuery();

        $this->today = strtotime(date('d-m-Y'));
        $this->model = $model;
        $this->fileName = $this->model->getKeyDoc();
    }

    public function setPrevNextDate(){
        $date = $this->model->getQueryFromKey('date');
        if($this->model->getQueryFromKey('checkdate') == 'prevdate'){
            $this->today = strtotime($date.' -1 day');
        } else if($this->model->getQueryFromKey('checkdate') == 'nextdate'){
            $this->today = strtotime($date.' +1 day');
        }
    }

    public function getDate(){
        return date('d-m-Y', $this->today);
    }

    public function simpanAmalan(){
        $this->json->setFileName($this->fileName);
        $jsonData = $this->json->getAllDataFromJSON();

        if(array_key_exists($this->today, $jsonData)){
            foreach ($this->model->getQueries() as $key=>$value){
                $jsonData[$this->today][$key] = $value;
            }
        } else{
            $jsonData[$this->today] = $this->model->getQueries();
        }

        $this->json->writeDataToJSON($jsonData);
    }

    public function getAmalanToday() {
        $this->json->setFileName($this->fileName);
        $jsonData = $this->json->getAllDataFromJSON();

        if(array_key_exists($this->today, $jsonData)){
            return $jsonData[$this->today];
        }
        return null;
    }

    public function calcChart(){
        $requirement = [
            'select' => 'amalan, min_minggu',
            'table' => 'amalan'
        ];

        $results = $this->db->selectQuery($requirement);
        $minAmalan = [];
        foreach($results as $result){
            $minAmalan[$result['amalan']] = $result['min_minggu'];
        }

        $jsonData = $this->json->getSpesificDataFromJSON(date('w', $this->today));

        $totalAmalan = [];
        foreach($minAmalan as $key=>$value){
            $totalAmalan[$key] = 0;
            foreach($jsonData as $amalan){
                if(array_key_exists($key, $amalan)){
                    $totalAmalan[$key] += $amalan[$key];
                }
            }
            $totalAmalan[$key] = round(($totalAmalan[$key] / $value)*100, 2);
            if($totalAmalan[$key] > 100){
                $totalAmalan[$key] = 100;
            }
        }

        return $totalAmalan;
    }

    public function isJdwlPuasa(){
        $day = date('N', $this->today);
        if($day == 1 || $day == 4){
            return true;
        }
        return false;
    }
}