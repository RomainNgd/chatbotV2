<?php
namespace Chatbot\Repository;

use Chatbot\Entity\Commande;
use MainRepository;
use PDO;

class CommandeRepository extends MainRepository
{

    public function __construct(){

    }

    public function getAll(){
        $query = 'SELECT * FROM c_commande';
        $get = $this->getDataBase()->prepare($query);
        $get->execute()
        or die(print_r($this->getDataBase()->errorInfo()));
        return $get->fetchAll();
    }

    public function getById($id){
        $query = 'SELECT * FROM c_commande WHERE id = :id';
        $get = $this->getDataBase()->prepare($query);
        $get->bindParam(':id', $id, PDO::PARAM_INT);
        $get->execute()
        or die(print_r($this->getDataBase()->errorInfo()));
        return $get->fetch(PDO::FETCH_ASSOC);
    }

    public function newCommande(Commande $commande){
        $query = 'INSERT INTO c_commande (email, create_at, product, status) VALUES (:email, :create_at, :product, :status)';
        $insert = $this->getDataBase()->prepare($query);
        $insert->bindValue(':email', $commande->getEmail());
        $insert->bindValue(':create_at', $commande->getCreateAt()->format('Y-m-d H:i:s'));
        $insert->bindValue(':product', $commande->getProduct());
        $insert->bindValue(':status', $commande->getStatus());
        $insert->execute() or die(print_r($this->getDataBase()->errorInfo()));
    }

    public function setStatus(Commande $commande){
        $query = 'UPDATE c_commande SET status = :status WHERE id = :id';
        $insert = $this->getDataBase()->prepare($query);
        $insert->bindValue(':status', $commande->getStatus());
        $insert->bindValue(':id', $commande->getId());
        $insert->execute() or die(print_r($this->getDataBase()->errorInfo()));
    }

}