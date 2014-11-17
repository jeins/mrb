<?php
/**
 * Created by PhpStorm.
 * User: akbar
 * Date: 17.11.14
 * Time: 15:36
 */

namespace mrb\portal\Model;

use Slim\Http\Request;

class MRBModel
{
    private $queries;

    public function __construct(Request $request){
        $this->queries = $request->params();
    }

    public function getQueries(){
        return $this->queries;
    }
}