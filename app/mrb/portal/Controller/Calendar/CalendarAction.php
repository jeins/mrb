<?php
/**
 * Created by PhpStorm.
 * User: MJA
 * Date: 09.02.2015
 * Time: 20:55
 */

namespace mrb\portal\Controller\Calendar;

use mrb\portal\Model\Query\JSONQuery;

class CalendarAction{
    public function __construct(){
        $this->jsonQuery = new JSONQuery();
        $this->jsonQuery->setFileName("");
    }

    public function insertEvent($title){

    }
}