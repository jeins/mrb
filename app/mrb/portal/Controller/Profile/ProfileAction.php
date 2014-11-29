<?php
/**
 * Created by PhpStorm.
 * User: Juan
 * Date: 29.11.14
 * Time: 13:46
 */

namespace mrb\portal\Controller\Profile;

use mrb\portal\Model\MRBModel;
use mrb\portal\Model\Query\QueryProfile;

class ProfileAction{

    public function __construct(MRBModel $model){
        $this->model = $model;
        $this->queryProfile = new QueryProfile($model->getUsername());
    }

    public function getAction($action){
        switch($action){
            case 'logininfo':
                $this->changePassword();
                break;
            case 'datapersonal':
                $this->dataPersonal();
                break;
        }
    }

    private function dataPersonal(){

    }

    private function changePassword(){
        $this->queryProfile->changePassword($this->model->getQueryFromKey('pass'));

        $this->model->removedAllCookies();
    }

    public function getLoginData(){
        return $this->model->getUsername();
    }
}