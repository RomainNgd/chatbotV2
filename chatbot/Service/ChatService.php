<?php

namespace Chatbot\Service;

use Chatbot\Repository\UserRepository;
use Validator\PasswordValidator;

require_once __DIR__ . '/../Service/ProduitService.php';
require_once __DIR__ . '/../Service/CategorieService.php';
require_once __DIR__ . '/../Service/KeywordService.php';
require_once __DIR__ . '/../Models/UserRepository.php';
require_once __DIR__ . '/../Validator/PasswordValidator.php';

class ChatService
{

    private ProduitService $produitService;
    private CategorieService $categorieService;
    private KeywordService $keywordService;
    private UserRepository $userRepository;

    public function __construct(){
        $this->produitService  = new ProduitService();
        $this->categorieService  = new CategorieService();
        $this->keywordService  = new KeywordService();
        $this->userRepository  = new UserRepository();

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
            case 'panier':

            case 'deconnection': {
                switch ($sentences){
                    case 'oui':
                        unset($_SESSION['customer']);
                        unset($_SESSION['lastkeyword']);
                        $response = 'Vous avez été déconnecter';
                        break;
                    case 'non':
                        unset($_SESSION['lastkeyword']);
                        $response = 'Procédure de deconnexion Abandonné, que puis-je faire pour vous ?';
                        break;
                    default :
                        $response = 'Je n\'ai aps compris votre message tapez oui ou non';
                }
                break;
            }
            case 'inscription' : {
                if (isset($_SESSION['customer']['connected']) === true ){
                    unset($_SESSION['lastkeyword']);
                    $response = 'Vous êtes dèjà connecté, conversation réinintalisé, que puis-je faire pour vous ?';
                } else {
                    switch ($sentences){
                        case 'oui':
                            $_SESSION['lastkeyword'] = 'inscription_login';
                            $response = 'Veuillez renseigné l\'identifiant qui vous servira à vous connecter';
                            break;
                        case 'non':
                            unset($_SESSION['lastkeyword']);
                            $response = 'Procédure d\'inscription Abandonné, que puis-je faire pour vous ?';
                            break;
                        default :
                            $response = 'je n\'ai pas compris votre réponse taper oui ou non';
                            break;
                    }
                }
                break;
            }
            case 'inscription_login': {
                if   ($this->userRepository->verifLoginDisonible($sentences)){
                    $_SESSION['lastkeyword'] = 'inscription_password';
                    $_SESSION['customer']['login'] = $sentences;
                    $response = 'Veuillez saisir un mot de passe';
                } else {
                    $response = 'l\'identifiant est dèjà pris veuillez en saisir un nouveau';
                }
                break;
            }
            case 'inscription_password' : {
                if (PasswordValidator::validPassword($sentences)){
                    $_SESSION['lastkeyword'] = 'inscription_password_confirm';
                    $_SESSION['customer']['password'] = password_hash($sentences, PASSWORD_DEFAULT);
                    $response = 'veuillez confirmez votre mot de passe';
                } else {
                    $response = 'le mot de passe doit contenir 8 caractères, une majuscule, une minuscule et un chiffre';
                }
                break;
            }
            case 'inscription_password_confirm': {
                if (password_verify($sentences, $_SESSION['customer']['password'])){
                    try {
                        $this->userRepository->bdCreerCompte($_SESSION['customer']['login'], $_SESSION['customer']['password']);
                        unset($_SESSION['customer']);
                        unset($_SESSION['lastkeyword']);
                        $response = 'L\'inscription a été effcectué avec succès veuillez taper la commande \'connexion\' afin de vous connecter';
                    } catch (\Exception $e){
                        $response = 'un problème est survenue veuillez contacter le support';
                    }

                } else {
                    $response = 'Les mot de passe ne sont pas similaire veuillez réessayez ou reinitialisé le chat afin de recommecer la procédure';
                }
                break;
            }
            case 'connection' : {
                if (isset($_SESSION['customer']['connected']) === true){
                    unset($_SESSION['lastkeyword']);
                    $response = 'Vous êtes dèjà connecté, conversation réinintalisé, que puis-je faire pour vous ?';
                } else {
                    switch ($sentences){
                        case 'oui':
                            $_SESSION['lastkeyword'] = 'connection_login';
                            $response = 'Veuillez renseigné votre identifiant';
                            break;
                        case 'non':
                            unset($_SESSION['lastkeyword']);
                            if (isset($_SESSION['customer'])){
                                unset($_SESSION['customer']);
                            }
                            $response = 'Procédure de connexion Abandonné, que puis-je faire pour vous ?';
                            break;
                        default :
                            $response = 'je n\'ai pas compris votre réponse taper oui ou non';
                            break;
                    }
                }
                break;
            }
            case 'connection_login' : {
                    $_SESSION['customer']['login'] = $sentences;
                    $_SESSION['lastkeyword'] = 'connection_password';
                    $response = 'Veuillez renseigner votre mot de passe';
                break;
            }
            case 'connection_password' : {
                if (!isset($_SESSION['customer']['login'])){
                    $response = 'Aucun identifiant n\'a été renseigné';
                } else {
                    if ($this->userRepository->verifLoginDisonible($_SESSION['customer']['login'])){
                        $response = 'Identifiant ou mot de passe incorrect, veuillez saisir votre identifiant';
                        $_SESSION['lastkeyword'] = 'connexion_login';
                    } elseif(!$this->userRepository->isCombinaisonValid($_SESSION['customer']['login'], $sentences)){
                        $response = 'Identifiant ou mot de passe incorrect, veuillez saisir votre identifiant';
                        $_SESSION['lastkeyword'] = 'connexion_login';
                    } else {
                        $_SESSION['customer']['connected'] = true;
                        unset($_SESSION['lastkeyword']);
                        $response = 'La connection a reussi';
                    }
                }
                break;
            }
            case 'product' : {
                $response = $this->produitService->searchProduit($sentences);
                if (empty($response)){
                    $response = $this->noEntity('Je ne trouve pas le produit veuillez vérifiez l\'orthographe',$sentences);
                }
                break;
            }
            case 'category' :{
                $response = $this->categorieService->searchCategorie($sentences);
                if (empty($response)){
                    $response = $this->noEntity('Je ne trouve pas la catégorie, vous l\'avez peut être mal orthographié',$sentences);
                }
                break;
            }
            case 'price' : {
                $response = $this->produitService->searchPrice($sentences);
                if (empty($response)){
                    $response = $this->noEntity('Je ne trouve pas la produit dont vous voulez connaitre le prix veuillez vérifiez l\'orthographe',$sentences);
                }
                break;
            }
            default : {
                $response = $this->noKeyword($sentences);
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
        if(!$response){
            $response = $this->produitService->searchProduit($sentences);
            if (!$response){
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
    public function resetChat($message) : string{
        unset($_SESSION['lastkeyword']);
        return json_encode($message);


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