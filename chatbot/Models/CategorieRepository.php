<?php

namespace Chatbot\Repository;

use Chatbot\Entity\Categorie;
use MainRepository;
use PDO;

class CategorieRepository extends MainRepository
{


    public function __construct(){
    }

    public function addCategorie(Categorie $categorie){
        $query = 'INSERT INTO c_categorie (categorie, slug, url) VALUES (:categorie, :slug, :url)';
        $insert = $this->getDataBase()->prepare($query);
        $insert->bindValue(':categorie', $categorie->getCategorie());
        $insert->bindValue(':slug', $categorie->getSlug());
        $insert->bindValue(':url', $categorie->getUrl());
        $insert->execute() or die(print_r($this->getDataBase()->errorInfo()));
    }

    public function getCategorie($word){
        $query = 'SELECT * FROM c_categorie WHERE categorie = :categorie';
        $get = $this->getDataBase()->prepare($query);
        $get->execute([
            'categorie' => $word,
        ]) or die(print_r($this->getDataBase()->errorInfo()));
        return $get->fetchAll();
    }

    public function removeCategorie(int $id){
        $query = 'DELETE FROM c_categorie WHERE id = :id';
        $get = $this->getDataBase()->prepare($query);
        $get->execute([
            'id' => $id,
        ]) or die(print_r($this->getDataBase()->errorInfo()));
        return $get->fetch();
    }

    public function getAllCategories(){
        $query = 'SELECT * FROM c_categorie';
        $get = $this->getDataBase()->prepare($query);
        $get->execute([]) or die(print_r($this->getDataBase()->errorInfo()));
        return $get->fetchAll();
    }

    public function getCategorieById(int $id){
        $query = 'SELECT * FROM c_categorie WHERE id = :id';
        $get = $this->getDataBase()->prepare($query);
        $get->bindValue(':id', $id, PDO::PARAM_INT);
        $get->execute() or die(print_r($this->getDataBase()->errorInfo()));
        return $get->fetch();
    }

    public function updateCategory(Categorie $category){
        $query = 'UPDATE c_categorie SET categorie = :categorie, slug = :slug, url = :url WHERE id = :id';
        $get = $this->getDataBase()->prepare($query);
        $get->bindValue(':id', $category->getId(), PDO::PARAM_INT);
        $get->bindValue(':categorie', $category->getCategorie(), PDO::PARAM_STR);
        $get->bindValue(':slug', $category->getSlug(), PDO::PARAM_STR);
        $get->bindValue(':url', $category->getUrl(), PDO::PARAM_STR);
        $get->execute() or die(print_r($this->getDataBase()->errorInfo()));
    }

    public function deleteCategory(int $id){
        $query = 'DELETE FROM c_categorie WHERE id = :id';
        $delete = $this->getDataBase()->prepare($query);
        $delete->bindValue(':id', $id, PDO::PARAM_INT);
        $delete->execute() or die(print_r($this->getDataBase()->errorInfo()));
    }
}