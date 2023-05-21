<?php

namespace Chatbot\Service;

require_once __DIR__ . '/../DataBase/dbConnection.php';
require_once __DIR__ . '/../Models/ProduitRepository.php';
require_once __DIR__ . '/../Service/HelperService.php';

use Chatbot\Database\dbConnection;
use Chatbot\Repository\ProduitRepository;

class ProduitService extends helperService
{
        private ProduitRepository $repository;

        public function __construct()
        {
            $this->repository = new ProduitRepository(new dbConnection());
        }

    /**
     * recheche des correpondance porduit a l'aide d'une phrase et renvoie une reponse
     * @param $sentence
     * @return string
     */
    public function searchProduit($sentence)
    {
        $responses = [];
        $words = explode(' ', $sentence);
        foreach ($words as $item){
            $item = strtolower(htmlentities($item));
            $results = $this->repository->getProduit($item);
            if ($results !== false){
                foreach ($results as $result){
                    $responses[] = $result;
                }
            }
        }
        if (count($responses) > 10){
            return 'Nous avons trouver plus de 10 correspondance produit veuillez précisez votre recherche';
        }elseif (count($responses) > 1){
            return $this->multipleResponse('produit', $responses);
        } elseif(count($responses) > 0) {
            return $this->simpleResponse('produit', $responses[0]);
        } else {
            return '';
        }
    }

    public function searchPrice($sentence){
        $product = $this->searchProduit($sentence);
        return $this->repository->getPrice($product[0]);
    }
}