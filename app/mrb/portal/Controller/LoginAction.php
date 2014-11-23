<?php
/**
 * Created by PhpStorm.
 * User: Juan
 * Date: 20.11.14
 * Time: 00:17
 */

namespace mrb\portal\Controller;

use mrb\portal\Model\Query\QueryUser;
use mrb\portal\Portal;

class LoginAction
{
    public function __construct(Portal $app){
        $this->app = $app;
        $this->username = $this->app->request->params('username');
        $this->keylog = $this->app->request->params('pass');

        $this->queryUser = new QueryUser($this->username, $this->keylog);
    }

    public function forwardUrl(){

        if($this->queryUser->isValid()){
            $groupDetail = $this->queryUser->getGroupLiqo();
            $groupName = $groupDetail['groupliqo'];
            $groupId = $groupDetail['id_groupliqo'];

            $this->app->redirect('/home/'.$groupName);
        }
    }
}