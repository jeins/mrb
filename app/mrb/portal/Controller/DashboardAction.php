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
        $jsonData = $this->json->getDataFromJSON();

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
        $jsonData = $this->json->getDataFromJSON();

        return $jsonData[$this->today];
    }
}