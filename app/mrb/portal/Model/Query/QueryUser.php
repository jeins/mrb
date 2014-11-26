<?php
/**
 * Created by PhpStorm.
 * User: Juan
 * Date: 19.11.14
 * Time: 23:04
 */

namespace mrb\portal\Model\Query;
use Symfony\Component\Yaml\Yaml as Yaml;

class QueryUser extends MainQuery
{
    private $username;

    private $keylog;

    public function __construct($username, $pass){
        parent::__construct();
        $configfile = $_SERVER['DOCUMENT_ROOT'] . '/../etc/config.yml';
        if(is_readable($configfile)) {
            $this->config = Yaml::parse(file_get_contents($configfile, true));
        } else{
            throw new \Exception("Configgile not found!");
        }

        $this->username = $username;
        $this->keylog = $pass;
    }

    public function insertNewUser($group){
        $attribute = [
            'table' => 'mrb_userlogin',
            'select' => 'COUNT(*) AS total',
            'terms' => "username='".$this->username."'"
        ];

        $result = $this->selectQuery($attribute);

        if(!($result[0]['total'] >= 1)){
            $attribute = [
                'table' => 'mrb_userlogin',
                'keys' => 'username, keylog, keydoc, groupliqo',
                'values' => "'".$this->username."', 'AES_ENCRYPT(".$this->keylog.",". $this->config['security']['key'].")', '".md5($this->keylog.$this->username.$group)."', '$group'"
            ];
            $this->insertQuery($attribute);
        }
    }

    public function isValid(){
        $attribute = [
            'table' => 'mrb_userlogin',
            'select' => 'keylog',
            'terms' => "username='".$this->username."'"
        ];
        $result = $this->selectQuery($attribute);
        $termKeylog = $result[0]['keylog'];

        $attribute = [
            'table' => 'mrb_userlogin',
            'select' => 'COUNT(*) AS total',
            'terms' => "username='".$this->username."' AND CONVERT('AES_DECRYPT($termKeylog,".$this->config['security']['key'].")' USING utf8) LIKE '%".$this->keylog."%'"
        ];
        $result = $this->selectQuery($attribute);
        if($result[0]['total'] == 1){
            return true;
        }
        return false;
    }

    public function getKeyDoc(){
        $attribute = [
            'table' => 'mrb_userlogin',
            'select' => 'keydoc',
            'terms' => "username='".$this->username."'"
        ];
        $result = $this->selectQuery($attribute);

        return $result[0]['keydoc'];
    }

    public function getGroupLiqo(){
        $attribute = [
            'table' => 'mrb_userlogin, mrb_groupliqo',
            'select' => 'id_groupliqo, mrb_groupliqo.groupliqo',
            'terms' => "username='".$this->username."' AND CONVERT('AES_DECRYPT(".$this->keylog.",".$this->config['security']['key'].")' USING utf8) LIKE '%".$this->keylog."%' AND id_groupliqo=mrb_userlogin.groupliqo"
        ];
        $result = $this->selectQuery($attribute);

        return $result[0];
    }
}