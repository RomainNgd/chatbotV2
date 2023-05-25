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
        $priority = 0;
        $keywords = $this->keywordRepository->getAllKeyword();
        foreach ($keywords as $keyword) {
            if (str_contains($sentence, $keyword['keyword']) !== false) {
                if ($keyword['priority'] > $priority){
                    $ressemblance = $keyword;
                }
                continue;
            }

            similar_text($sentence, $keyword['keyword'], $similarity);
            $seuilSimilarite = 70;
            if ($similarity >= $seuilSimilarite) {
                if ($keyword['priority'] > $priority){
                    $ressemblance = $keyword;
                }
            }
        }
        if (!empty($ressemblance)){
            $response = $this->responseRepository->getResponse($ressemblance['response_id']);
            $slug = $this->responseRepository->getSlug($ressemblance['response_id']);
            if (!empty($slug)){
                $_SESSION['lastkeyword'] = $slug['slug'];
            }
        } else{
            $response = '';
        }

        return  $response['response'];
    }
}