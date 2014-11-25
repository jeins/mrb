<?php
/**
 * Created by PhpStorm.
 * User: Juan
 * Date: 20.11.14
 * Time: 00:17
 */

namespace mrb\portal\Controller;

use mrb\portal\Model\MRBModel;
use mrb\portal\Model\Query\QueryUser;

class LoginAction
{
    public function __construct(MRBModel $model){
        $this->queryUser = new QueryUser(
            $model->getQueryFromKey('username'),
            $model->getQueryFromKey('pass')
        );
    }

    public function setKeyDoc(){
        return $this->queryUser->getKeyDoc();
    }

    public function forwardUrl(){

        if($this->queryUser->isValid()){
            $groupDetail = $this->queryUser->getGroupLiqo();
            $groupName = $groupDetail['groupliqo'];
            $groupId = $groupDetail['id_groupliqo'];

           return '/home';
        }
    }
}