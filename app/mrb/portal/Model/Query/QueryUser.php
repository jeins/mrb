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
        return true;
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
}