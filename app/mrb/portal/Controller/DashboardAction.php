<?php
/**
 * Created by PhpStorm.
 * User: akbar
 * Date: 17.11.14
 * Time: 15:21
 */

namespace mrb\portal\Controller;

use mrb\portal\Model\MRBModel;
use mrb\portal\Model\Query\JSONQuery;
use mrb\portal\Model\Query\MainQuery;

Class DashboardAction
{
    public function __construct(MRBModel $model) {
        $this->db = new MainQuery();
        $this->json = new JSONQuery();
        $this->functions = new Functions();
        $this->queries = $model->getQueries();
        $this->today = strtotime(date('d-m-Y'));
    }

    public function simpanAmalan(){
        $fileName = 'juan.json';
        $this->json->setFileName($fileName);
        $jsonData = $this->json->getAllDataFromJSON();

        if(array_key_exists($this->today, $jsonData)){
            foreach ($this->queries as $key=>$value){
                $jsonData[$this->today][$key] = $value;
            }
        } else{
            $jsonData[$this->today] = $this->queries;
        }

        $this->json->writeDataToJSON($jsonData);
    }

    public function getAmalanToday() {
        $fileName = 'juan.json';
        $this->json->setFileName($fileName);
        $jsonData = $this->json->getAllDataFromJSON();

        return $jsonData[$this->today];
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
}