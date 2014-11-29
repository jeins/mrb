<?php
/**
 * Created by PhpStorm.
 * User: akbar
 * Date: 17.11.14
 * Time: 15:36
 */

namespace mrb\portal\Model;

class MRBModel
{
    private $queries;

    private $keyDoc;

    private $username;

    public function setUsername($username){
        $this->username = $username;
    }

    public function getUsername(){
        return $this->username;
    }

    public function setQueries($queries){
        $this->queries = $queries;
    }

    public function getQueries(){
        return $this->queries;
    }

    public function getQueryFromKey($key){
        return $this->queries[$key];
    }

    public function setKeyDoc($keyDoc){
        $this->keyDoc = $keyDoc;
    }

    public function getKeyDoc(){
        return $this->keyDoc;
    }

    public function removedAllCookies(){
        if (isset($_SERVER['HTTP_COOKIE'])) {
            $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
            foreach($cookies as $cookie) {
                $parts = explode('=', $cookie);
                $name = trim($parts[0]);
                setcookie($name, '', time()-1000);
                setcookie($name, '', time()-1000, '/');
            }
        }
    }
}