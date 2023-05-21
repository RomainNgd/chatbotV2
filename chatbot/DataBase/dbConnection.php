<?php
namespace Chatbot\Database;
use Exception;
use PDO;
require_once 'dbConfig.php';
class dbConnection extends dbConfig {

    public function getDataBase(){
        try{
            $db = new PDO('mysql:host='.$this->host.';dbname='.$this->dataBase.';charset=utf8', $this->user, $this->password);
        }
        catch(Exception $exception){
            die('Erreur : ' . $exception->getMessage());
        }

        return $db;
    }

}
