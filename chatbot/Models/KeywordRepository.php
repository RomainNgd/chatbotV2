<?php

namespace Chatbot\Repository;

use Chatbot\Entity\Keyword;
use Chatbot\database\dbConnection;
use MainRepository;
use PDO;

class KeywordRepository extends MainRepository
{

    public function __construct(){
    }

    public function addKeyword(Keyword $keyword){
        $query = 'INSERT INTO c_keyword (keyword, response_id, priority) VALUES (:keyword, :response_id, :priority)';
        $insert = $this->getDataBase()->prepare($query);
        $insert->bindValue(':keyword', $keyword->getKeyword());
        $insert->bindValue(':response_id', $keyword->getResponse()->getId());
        $insert->bindValue(':priority', $keyword->getPriority());
        $insert->execute() or die(print_r($this->getDataBase()->errorInfo()));
    }

    public function updateKeyword(Keyword $keyword)
    {
        $query = 'UPDATE c_keyword SET keyword= :keyword, priority = :priority WHERE id = :id';
        $update = $this->getDataBase()->prepare($query);
        $update->bindValue(':keyword', $keyword->getKeyword());
        $update->bindValue(':priority', $keyword->getPriority());
        $update->bindValue(':id', $keyword->getId());
        $update->execute() or die(print_r($this->getDataBase()->errorInfo()));
    }

    public function getKeyword($word){
        $query = 'SELECT * FROM c_keyword WHERE keyword = :keyword';
        $get = $this->getDataBase()->prepare($query);
        $get->execute([
            'keyword' => $word,
        ]) or die(print_r($this->getDataBase()->errorInfo()));
        return $get->fetch();
    }

    public function removeKeyword($id){
        $query = 'DELETE FROM c_keyword WHERE id = :id';
        $get = $this->getDataBase()->prepare($query);
        $get->execute([
            'id' => $id,
        ]) or die(print_r($this->getDataBase()->errorInfo()));
        return $get->fetch();
    }

    public function getKeywordAsResponse(int $id) : array{
        $query = 'SELECT * FROM c_keyword WHERE response_id = :id';
        $get = $this->getDataBase()->prepare($query);
        $get->execute([
            'id' => $id,
        ]) or die(print_r($this->getDataBase()->errorInfo()));
        return $get->fetchAll();
    }

    public function checkKeywordExistsForEdit(Keyword $keyword) {
        $query = "SELECT COUNT(*) FROM c_keyword WHERE keyword = :keyword AND id != :id";
        $stmt = $this->getDataBase()->prepare($query);
        $stmt->bindValue(':keyword', $keyword->getKeyword());
        $stmt->bindValue(':id', $keyword->getId(), PDO::PARAM_INT);
        $stmt->execute();

        $count = $stmt->fetchColumn();

        return $count > 0;
    }

    function checkKeywordExistsForAdd(Keyword $keyword) {
        $query = "SELECT COUNT(*) FROM c_keyword WHERE keyword = :keyword";
        $stmt = $this->getDataBase()->prepare($query);
        $stmt->bindValue(':keyword', $keyword->getKeyword());
        $stmt->execute();

        $count = $stmt->fetchColumn();

        return $count > 0;
    }
}