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

        $this->today = strtotime(date('d-m-Y'));
        $this->model = $model;
        $this->fileName = $this->model->getKeyDoc();

        $this->json = new JSONQuery();
        $this->json->setFileName($this->fileName);
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
        $jsonData = $this->json->getAllDataFromJSON();
        $today = strtotime($this->model->getQueryFromKey('date'));

        if(array_key_exists($today, $jsonData)){
            foreach ($this->model->getQueries() as $key=>$value){
                $jsonData[$today][$key] = $value;
            }
        } else{
            $jsonData[$today] = $this->model->getQueries();
        }

        $this->json->writeDataToJSON($jsonData);
    }

    public function getAmalanToday() {
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

    public function getWeekStatus(){
        $arrDayNum = [];
        $tmpDate = strtotime(date('d-m-Y'));
        while(true){
            $date = strtotime(date('d-m-Y', $tmpDate).' -1 day');
            $tmpDate = $date;
            $dayNum = date('w', $tmpDate);
            $arrDayNum [$dayNum]= $tmpDate;
            if($dayNum == 1){
                break;
            }
        }

        $results = [];
        for($i=1; $i<=7; $i++){
            if($i <= sizeof($arrDayNum)){
                if($this->json->isWeekAvailable($arrDayNum[$i])){
                    $results[$i] = 'background-color: #dff0d8';
                } else{
                    $results[$i] = 'background-color: #f2dede';
                }
            } else if($i == date('w', strtotime(date('d-m-Y')))){
                $results[$i] = '';
            }
            else{
                $results[$i] = 'background-color: #cccccc';
            }

            if($i == (date('w', $this->today))){
                $results[$i] .= ';border-color: #ff0000';
            }
        }
        return $results;
    }
}