<?php
/**
 * Created by PhpStorm.
 * User: akbar
 * Date: 19.11.14
 * Time: 18:14
 */

namespace mrb\portal\Controller;

use mrb\portal\Model\Query\JSONQuery;
use mrb\portal\Portal;

class StatistikAction
{
    private $app;
    private $amalan;

    public function __construct(Portal $app){
        $this->app = $app;
        $this->json = new JSONQuery();
        $this->json->setFileName($this->app->request->params('filename'));
        $this->amalan = $app->request->params('amalan');
    }

    public function generateJSON(){
        $jsonData = $this->json->getAllDataFromJSON();
        $tmpData = array();

        $index = 0;
        foreach ($jsonData as $key=>$value) {
            $y = date('o', $key);
            $d = date('j', $key);
            $m = date('n', $key)-1;
            if(array_key_exists($this->amalan, $value)){
                $tmpData[$index] = array("Date.UTC($y, $m, $d), " .$value[$this->amalan]);
            }
            $index++;
        }

        $response = $this->app->response();
        $response['Content-type'] = 'application/json';

        $json = json_encode($tmpData);
        $response->body('?('.str_replace('"', '',$json).");");
    }
}