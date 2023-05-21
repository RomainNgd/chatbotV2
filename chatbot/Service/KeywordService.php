<?php

namespace Chatbot\Service;

require_once __DIR__. '/../DataBase/dbConnection.php';
require_once __DIR__ . '/../Models/ResponseRepository.php';
require_once __DIR__ . '/../Models/keywordRepository.php';
require_once __DIR__ . '/../Service/HelperService.php';

use Chatbot\Repository\KeywordRepository;
use Chatbot\Repository\ResponseRepository;
use Chatbot\Database\dbConnection;

class KeywordService extends helperService
{

    private KeywordRepository $keywordRepository;
    private ResponseRepository $responseRepository;

    public function __construct(){
        $this->keywordRepository = new KeywordRepository(new dbConnection());
        $this->responseRepository = new ResponseRepository(new dbConnection());
    }

    /**
     * rechecrhe un keyword en bdd avec une phrase et renvoie la reponse associé
     * @param $sentence
     * @return array|string
     */
    public function searchKeyword($sentence): array|string
    {
        $words = explode(' ', $sentence);
        $priority = 0;
        $response = '';
        foreach ($words as $item){
            $item = strtolower(htmlentities($item));
            $result = $this->responseRepository->getResponse($item);
            if ($result !== false && $result['priority'] > $priority){
                $response = $result['response'];
                $priority = $result['priority'];
                $_SESSION['lastkeyword'] = $result['keyword'];
            }
        }
        return  $response;
    }
}