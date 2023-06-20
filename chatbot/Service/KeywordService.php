<?php

namespace Chatbot\Service;

require_once __DIR__. '/../DataBase/dbConnection.php';
require_once __DIR__ . '/../Models/ResponseRepository.php';
require_once __DIR__ . '/../Models/keywordRepository.php';
require_once __DIR__ . '/../Service/HelperService.php';
require_once __DIR__ . '/../Service/ChatService.php';

use Chatbot\Repository\KeywordRepository;
use Chatbot\Repository\ResponseRepository;
use Chatbot\Database\dbConnection;

class KeywordService extends helperService
{

    private KeywordRepository $keywordRepository;
    private ResponseRepository $responseRepository;

    public function __construct(){
        $this->keywordRepository = new KeywordRepository();
        $this->responseRepository = new ResponseRepository();
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
                if ($keyword['priority'] > $priority) {
                    $ressemblance = $keyword;
                }
            }
        }
        if (empty($ressemblance)){
            foreach ($keywords as $keyword){
                similar_text($sentence, $keyword['keyword'], $similarity);
                $seuilSimilarite = 70;
                if ($similarity >= $seuilSimilarite) {
                    if ($keyword['priority'] > $priority){
                        $ressemblance = $keyword;
                    }
                }
            }
        }
        if (!empty($ressemblance)){
            $response = $this->responseRepository->getResponse($ressemblance['response_id']);
            $response = $response['response'];
            $slug = $this->responseRepository->getSlug($ressemblance['response_id']);
            $action = $this->responseRepository->getAction($ressemblance['response_id']);
            if (!empty($slug)){
                $_SESSION['lastkeyword'] = $slug['slug'];
            }
            if (!empty($action)){
                $_SESSION['action'] = $action['action'];
            }
        } else{
            $response = '';
        }

        return  $response;
    }
}