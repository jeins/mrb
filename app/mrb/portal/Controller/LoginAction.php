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

        $this->queryUser = new QueryUser();

        $this->app = $app;
        $this->username = $this->app->request->params('username');
        $this->keylog = $this->app->request->params('pass');
    }

    public function forwardUrl(){

        if($this->queryUser->isValid($this->username, $this->keylog)){echo "OK";die();
            $groupDetail = $this->queryUser->getGroupLiqo($this->username, $this->keylog);
            $groupName = $groupDetail['groupliqo'];
            $groupId = $groupDetail['id_groupliqo'];

            $this->app->redirect('/home/'.$groupName);
        }
    }
}