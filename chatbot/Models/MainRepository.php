<?php

use Chatbot\Database\dbConnection;

require_once (__DIR__ . '/../DataBase/dbConnection.php');

Abstract class MainRepository extends dbConnection
{

    public function getDatas(){
        $req = $this->getDataBase()->prepare("SELECT * FROM chatbot");
        $req->execute();
        $datas = $req->fetchAll(PDO::FETCH_ASSOC);
        $req->closeCursor();
        return $datas;
    }
}