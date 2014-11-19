<?php
/**
 * Created by PhpStorm.
 * User: Juan
 * Date: 19.11.14
 * Time: 23:37
 */

namespace mrb\portal\Controller\Admin;

use mrb\portal\Model\Query\JSONQuery;
use mrb\portal\Model\Query\QueryUser;

class NewUserAction
{
    public function __construct($app){
        $this->app = $app;

        $this->username = $this->app->request->params('username');
        $this->keylog = $this->app->request->params('pass');
        $this->group = $this->app->request->params('group');

        $this->query = new QueryUser();
        $this->json = new JSONQuery();
    }

    public function action(){
        $this->query->insertNewUser($this->username, $this->keylog, $this->group);
        $keyDoc = $this->query->getKeyDoc($this->username, $this->keylog);

        $this->json->setFileName($keyDoc);
        $this->json->createJSONFile();

        echo "Added New user!";
    }
}