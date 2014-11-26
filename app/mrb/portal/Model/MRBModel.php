<?php
/**
 * Created by PhpStorm.
 * User: akbar
 * Date: 17.11.14
 * Time: 15:36
 */

namespace mrb\portal\Model;

class MRBModel
{
    private $queries;

    private $keyDoc;

    public function setQueries($queries){
        $this->queries = $queries;
    }

    public function getQueries(){
        return $this->queries;
    }

    public function getQueryFromKey($key){
        return $this->queries[$key];
    }

    public function setKeyDoc($keyDoc){
        $this->keyDoc = $keyDoc;
    }

    public function getKeyDoc(){
        return $this->keyDoc;
    }
}