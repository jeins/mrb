<?php
/**
 * Created by PhpStorm.
 * User: Juan
 * Date: 29.11.14
 * Time: 13:43
 */

namespace mrb\portal\Model\Query;

use Symfony\Component\Yaml\Yaml;

class QueryProfile extends MainQuery
{
    public function __construct($username){
        parent::__construct();
        $configfile = $_SERVER['DOCUMENT_ROOT'] . '/../etc/config.yml';
        if(is_readable($configfile)) {
            $this->config = Yaml::parse(file_get_contents($configfile, true));
        } else{
            throw new \Exception("Configgile not found!");
        }

        $this->username = $username;
    }

    public function insertDataPersonal($data){

    }

    public function getDataPersonal(){

    }

    public function changePassword($newPass){
        $requirement = [
            'table' => 'mrb_userlogin',
            'update' => "keylog='AES_ENCRYPT(".$newPass.",". $this->config['security']['key'].")'",
            'terms' => "username='".$this->username."'"
        ];
        $this->updateQuery($requirement);
    }
}