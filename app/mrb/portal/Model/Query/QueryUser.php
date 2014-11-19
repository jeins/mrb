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
    public function __construct(){
        parent::__construct();
        $configfile = $_SERVER['DOCUMENT_ROOT'] . '/../etc/config.yml';
        if(is_readable($configfile)) {
            $this->config = Yaml::parse(file_get_contents($configfile, true));
        } else{
            throw new \Exception("Configgile not found!");
        }
    }

    public function insertNewUser($name, $keylog, $group){
        $attribute = [
            'table' => 'mrb_userlogin',
            'keys' => 'username, keylog, keydoc, groupliqo',
            'values' => "'$name', 'AES_ENCRYPT($keylog,". $this->config['security']['key'].")', '".md5($keylog.$name.$group)."', '$group'"
        ];
        $this->insertQuery($attribute);
    }

    public function isValid($name, $keylog){
        $attribute = [
            'table' => 'mrb_userlogin',
            'select' => 'COUNT(*) AS total',
            'terms' => "username='$name' AND CONVERT('AES_DECRYPT($keylog,".$this->config['security']['key'].")' USING utf8) LIKE '%$keylog%'"
        ];
        $result = $this->selectQuery($attribute);
        if($result[0]['total'] == 1){
            return true;
        }
        return false;
    }

    public function getKeyDoc($name, $keylog){
        $attribute = [
            'table' => 'mrb_userlogin',
            'select' => 'keydoc',
            'terms' => "username='$name' AND CONVERT('AES_DECRYPT($keylog,".$this->config['security']['key'].")' USING utf8) LIKE '%$keylog%'"
        ];
        $result = $this->selectQuery($attribute);

        return $result[0]['keydoc'];
    }

    public function getGroupLiqo($name, $keylog){
        $attribute = [
            'table' => 'mrb_userlogin, mrb_groupliqo',
            'select' => 'id_groupliqo, mrb_groupliqo.groupliqo',
            'terms' => "username='$name' AND CONVERT('AES_DECRYPT($keylog,".$this->config['security']['key'].")' USING utf8) LIKE '%$keylog%' AND id_groupliqo=mrb_userlogin.groupliqo"
        ];
        $result = $this->selectQuery($attribute);

        return $result[0];
    }
}