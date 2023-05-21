<?php

namespace Chatbot\Service;

require_once __DIR__ . '/../Service/ProduitService.php';
require_once __DIR__ . '/../Service/CategorieService.php';
require_once __DIR__ . '/../Service/KeywordService.php';

class ChatService
{

    private ProduitService $produitService;
    private CategorieService $categorieService;
    private KeywordService $keywordService;

    public function __construct(){
        $this->produitService  = new ProduitService();
        $this->categorieService  = new CategorieService();
        $this->keywordService  = new KeywordService();

    }


    /**
     * Permet de retourne le message en json
     * @param $sentences
     * @return false|string
     */
    public function findMessage($sentences){
        if (isset($_SESSION['lastkeyword'])){
            $response = $this->isKeyword($sentences);
        } else{
            $response = $this->noKeyword($sentences);
        }
        return json_encode($response);
    }

    /**
     * retourne le message correspondant en fonction de la demande précédente de l'utilisateur
     * @param $sentences
     * @return string
     */
    public function isKeyword($sentences): string{
        switch ($_SESSION['lastkeyword']){
            case 'produit' : {
                $response = $this->produitService->searchProduit($sentences);
                if (empty($response)){
                    $response = $this->noEntity('Je ne trouve pas le produit veuillez vérifiez l\'orthographe',$sentences);
                }
                break;
            }
            case 'categorie' :{
                $response = $this->categorieService->searchCategorie($sentences);
                if (empty($response)){
                    $response = $this->noEntity('Je ne trouve pas la catégorie, vous l\'avez peut être mal orthographié',$sentences);
                }
                break;
            }
            case 'prix' : {
                $response = $this->produitService->searchPrice($sentences);
                if (empty($response)){
                    $response = $this->noEntity('Je ne trouve pas la produit dont vous voulez connaitre le prix veuillez vérifiez l\'orthographe',$sentences);
                }
                break;
            }
            default : {
                $response = $this->keywordService->searchKeyword($sentences);
                if (empty($response)){
                    $response = 'Je n\'ai pas compris votre message';
                }
                break;
            }
        }
        return $response;
    }

    /**
     * retourne le message qui correspond quand l'utilisarteur n'a pas précisé sa demande
     * @param $sentences
     * @return array|string
     */
    public function noKeyword($sentences){
        $response = $this->keywordService->searchKeyword($sentences);
        if($response){
            $response = $this->produitService->searchProduit($sentences);
            if (empty($response)){
                $response = $this->categorieService->searchCategorie($sentences);
            }
        }
        if (!$response){
            $response = "Je n'ai pas compris votre message";
        }

        return $response;
    }


    /***
     * réinitalise la conversation et renvoie un message de suvccès
     * @return string
     */
    public function resetChat() : string{
        unset($_SESSION['lastkeyword']);
        return json_encode('Le chat a été réinitialisé avec succés. Que puis-je faire pour vous ? ');


    }


    /**
     * utilisé quand l'utilisateur a précisé ca demande mais qu'elle n'a pas aboutit
     * @param $message
     * @param $sentences
     * @return string
     */
    private function noEntity($message, $sentences) :string{
        $response = $this->keywordService->searchKeyword($sentences);
        if (empty($response)){
            $response = $message;
        }
        return $response;
    }
}