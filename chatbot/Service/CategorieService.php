<?php

namespace Chatbot\Service;
require_once __DIR__ . '/../Models/CategorieRepository.php';
require_once __DIR__. '/../DataBase/dbConnection.php';
require_once __DIR__ . '/../Service/HelperService.php';

use Chatbot\Repository\CategorieRepository;
use Chatbot\Database\dbConnection;

class CategorieService extends helperService
{

    private CategorieRepository $repository;


    public function __construct(){
        $this->repository = new CategorieRepository(new dbConnection());
    }

    /**
     * cherche une categorie en base de donnée a partir d'une phrase et retourne un message
     * @param $sentence
     * @return array|string
     */
    public function searchCategorie($sentence) : array|string
    {
        $responses = [];
        $words = explode(' ', $sentence);
        foreach ($words as $item){
            $item = strtolower(htmlentities($item));
            $results = $this->repository->getCategorie($item);
            if ($results !== false){
                foreach ($results as $result){
                    $responses[] = $result;
                }
            }
        }
        if (count($responses) > 10){
            return 'Nous avons trouver plus de 10 correpondance de categorie veuillez précisez votre rehcherche';
        }elseif (count($responses) > 1){
            return $this->multipleResponse('categorie', $responses);
        } elseif(count($responses) > 0) {
            return $this->simpleResponse('categorie', $responses[0]);
        } else {
            return '';
        }
    }
}