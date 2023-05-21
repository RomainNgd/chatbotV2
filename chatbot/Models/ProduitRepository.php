<?php

namespace Chatbot\Repository;

require_once 'MainRepository.php';
require_once __DIR__ . '/../Entity/Produit.php';

use Chatbot\Entity\Produit;
use MainRepository;
use PDO;

class ProduitRepository extends MainRepository
{

    public function __construct(){
    }

    public function addProduit(Produit $produit){
        $query = 'INSERT INTO c_produit (produit, prix, slug, ref, categorie_id, url) VALUES (:produit, :prix, :slug, :ref, :categorie_id, :url)';
        $insert = $this->getDataBase()->prepare($query);
        $insert->execute([
            'produit' => $produit->getProduit(),
            'prix' => $produit->getPrix(),
            'slug' => $produit->getSlug(),
            'ref' => $produit->getRef(),
            'categorie_id' => $produit->getCategorie(),
            'url' => $produit->getUrl(),
        ]) or die(print_r($this->getDataBase()->errorInfo()));
    }

    public function getProduit(string $word){
        if (strlen($word) >= 4){
            $query = 'SELECT produit, url FROM c_produit WHERE produit LIKE "%'.$word[0].$word[1].$word[2].$word[3].'%"';
        }
        elseif(strlen($word) > 1){
            $query = 'SELECT produit, url FROM c_produit WHERE produit LIKE "'.$word.'"';
        }else{
            return false;
        }
        $get = $this->getDataBase()->prepare($query);
        $get->execute() or die(print_r($this->getDataBase()->errorInfo()));
        return $get->fetchAll();
    }

    public function updateProduit(Produit $produit){
        $query = 'UPDATE c_produit as p SET p.produit = :produit, p.prix =:prix, p.slug= :slug, p.url = :url, p.ref = :ref, p.categorie_id = :categorie_id WHERE id = :id';
        $update = $this->getDataBase()->prepare($query);
        $update->bindValue(':produit', $produit->getProduit(), PDO::PARAM_STR);
        $update->bindValue(':prix', $produit->getPrix(), PDO::PARAM_STR);
        $update->bindValue(':slug', $produit->getSlug(), PDO::PARAM_STR);
        $update->bindValue(':ref', $produit->getRef(), PDO::PARAM_INT);
        $update->bindValue(':id', $produit->getId(), PDO::PARAM_INT);
        $update->bindValue(':categorie_id', $produit->getCategorie(), PDO::PARAM_INT);
        $update->bindValue(':url', $produit->getUrl(), PDO::PARAM_STR);
        $update->execute() or die(print_r($this->getDataBase()->errorInfo()));
    }

    public function removeProduit(int $id){
        $query = 'DELETE FROM c_produit WHERE id = :id';
        $get = $this->getDataBase()->prepare($query);
        $get->bindValue(':id', $id, PDO::PARAM_INT);
        $get->execute() or die(print_r($this->getDataBase()->errorInfo()));
        return true;
    }

    public function getPrice($product){
        $query = 'SELECT produit, prix, slug FROM c_produit WHERE produit = :produit';
        $get = $this->getDataBase()->prepare($query);
        $get->execute([
            'produit' => $product,
        ]);
        return $get->fetch();
    }

    public function getAllProduct():array{
        $query = 'SELECT p.id, p.produit, p.prix, p.slug, p.ref, c.categorie, p.url FROM c_produit as p INNER JOIN c_categorie as c ON p.categorie_id = c.id';
        $get = $this->getDataBase()->prepare($query);
        $get->execute();
        return $get->fetchAll();
    }

    public function getProductById(int $id) {
        $query = 'SELECT * FROM c_produit WHERE id = :id';
        $get = $this->getDataBase()->prepare($query);
        $get->bindValue(':id', $id);
        $get->execute();
        return $get->fetch();
    }
}