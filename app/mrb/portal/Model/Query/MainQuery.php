<?php
/**
 * Created by PhpStorm.
 * User: akbar
 * Date: 12.11.14
 * Time: 16:21
 */

namespace mrb\portal\Model\Query;

use Symfony\Component\Yaml\Yaml as Yaml;

class MainQuery
{
    public function __construct()
    {
        $configfile = $_SERVER['DOCUMENT_ROOT'] . '/../etc/config.yml';
        if(is_readable($configfile)) {
            $this->config = Yaml::parse(file_get_contents($configfile, true));
            $this->mysqli = new \mysqli(
                $this->config['mysqli']['db_host'],
                $this->config['mysqli']['db_user'],
                $this->config['mysqli']['db_pass'],
                $this->config['mysqli']['db_name']
            );
        } else{
            throw new \Exception("Configgile not found!");
        }
    }

    public function selectQuery($requirement)
    {
        $query = "SELECT ". $requirement['select']. " FROM ". $requirement['table'];

        if(array_key_exists('terms', $requirement)){
            $query = "SELECT ". $requirement['select']. " FROM ". $requirement['table']. " WHERE ". $requirement['terms'];
        }

        $resultSet = $this->mysqli->query($query);
        $results_array = [];echo $query;
        while ($row = $resultSet->fetch_assoc()) {
            $results_array[] = $row;
        }
        return $results_array;
    }

    public function insertQuery($requirement)
    {
        $query = "INSERT INTO ". $requirement['table'] ."(". $requirement['keys'] .") VALUES(". $requirement['values'] .")";

        if(array_key_exists('terms', $requirement)){
            $query = "INSERT INTO ". $requirement['table'] ."(". $requirement['keys'] .") VALUES(". $requirement['values'] .") WHERE ". $requirement['terms'];
        }

        $this->mysqli->query($query);
    }

    public function updateQuery($requirement)
    {
        $query = "UPDATE ". $requirement['table'] ." SET ". $requirement['update']. " WHERE ". $requirement['terms'];
        $this->mysqli->query($query);
    }

    public function deleteQuery($requirement)
    {
        $query = "DELETE FROM ". $requirement['table'] ." WHERE ". $requirement['terms'];
        $this->mysqli->query($query);
    }
}