<?php
/**
 * Created by PhpStorm.
 * User: akbar
 * Date: 19.11.14
 * Time: 18:14
 */

namespace mrb\portal\Controller\Home;

use mrb\portal\Model\MRBModel;
use mrb\portal\Model\Query\JSONQuery;

class StatistikAction
{
    private $amalan;

    public function __construct(MRBModel $model){
        $this->json = new JSONQuery();
        $this->json->setFileName($model->getKeyDoc());
        $this->amalan = $model->getQueryFromKey('amalan');
    }

    public function generateJSON(){
        $jsonData = $this->json->getAllDataFromJSON();
        $tmpData = [];

        $index = 0;
        foreach ($jsonData as $key=>$value) {
            $y = date('o', $key);
            $d = date('j', $key);
            $m = date('n', $key)-1;
            if(array_key_exists($this->amalan, $value)){
                $tmpData[$index] = [$y, $m, $d, $value[$this->amalan]];
                $index++;
            }
        }

        return json_encode($tmpData);
    }
}