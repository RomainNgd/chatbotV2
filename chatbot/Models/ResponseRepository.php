<?php

namespace Chatbot\Repository;

use Chatbot\Entity\Keyword;
use Chatbot\Entity\Produit;
use Chatbot\Entity\Response;
use MainRepository;
use PDO;

class ResponseRepository extends MainRepository {

    public function __construct(){
    }

    public function getResponseId(string $response){
        $query = 'SELECT * FROM c_response WHERE response = :response';
        $get = $this->getDataBase()->prepare($query);
        $get->execute([
            'response' => $response,
        ]) or die(print_r($this->getDataBase()->errorInfo()));
        return $get->fetch();
    }

    public function addResponse(Response $response){
        $query = 'INSERT INTO c_response (response) VALUES (:response)';
        $insert = $this->getDataBase()->prepare($query);
        $insert->execute([
            'response' => $response->getResponse(),
        ]) or die(print_r($this->getDataBase()->errorInfo()));
    }

    public function updateResponse(Response $response): void{
        $query = 'UPDATE c_response SET response = :response WHERE id = :id';
        $update = $this->getDataBase()->prepare($query);
        $update->bindValue(':response', $response->getResponse());
        $update->bindValue(':id', $response->getId());
        $update->execute() or die(print_r($this->getDataBase()->errorInfo()));
    }

    public function getResponse(int $id){
        $query = 'SELECT response FROM c_response WHERE id = :id';
        $get = $this->getDataBase()->prepare($query);
        $get->execute([
            'id' => $id,
        ]) or die(print_r($this->getDataBase()->errorInfo()));
        return $get->fetch();
    }

    public function getSlug(int $id){
        $query = 'SELECT slug FROM c_response WHERE id = :id';
        $get = $this->getDataBase()->prepare($query);
        $get->execute([
            'id' => $id,
        ]) or die(print_r($this->getDataBase()->errorInfo()));
        return $get->fetch();
    }

    public function getAllResponse(){
        $query = 'SELECT id, response FROM c_response';
        $get = $this->getDataBase()->prepare($query);
        $get->execute();
        return $get->fetchAll();
    }

    public function getOneResponse($id){
        $query = 'SELECT response, id FROM c_response WHERE id = :id';
        $get = $this->getDataBase()->prepare($query);
        $get->execute([
            'id' => $id
        ]);
        return $get->fetchAll();
    }

    public function removeResponse(int $id){
        $query = 'DELETE FROM c_response WHERE id = :id';
        $delete = $this->getDataBase()->prepare($query);
        $delete->bindValue(':id', $id, PDO::PARAM_INT);
        $delete->execute();
    }


    public function checkResponseExistsForEdit(Response $response) {
        $query = "SELECT COUNT(*) FROM c_response WHERE response = :response AND id != :id";
        $stmt = $this->getDataBase()->prepare($query);
        $stmt->bindValue(':response', $response->getResponse());
        $stmt->bindValue(':id', $response->getId(), PDO::PARAM_INT);
        $stmt->execute();

        $count = $stmt->fetchColumn();

        return $count > 0;
    }

    function checkResponseExistsForAdd(Response $response) {
        $query = "SELECT COUNT(*) FROM c_response WHERE response = :response";
        $stmt = $this->getDataBase()->prepare($query);
        $stmt->bindValue(':response', $response->getResponse());
        $stmt->execute();

        $count = $stmt->fetchColumn();

        return $count > 0;
    }
}
