<?php

namespace Chatbot\Service;

use Chatbot\Repository\ProduitRepository;
use Chatbot\Repository\UserRepository;
use Validator\PasswordValidator;

require_once __DIR__ . '/../Service/ProduitService.php';
require_once __DIR__ . '/../Service/CategorieService.php';
require_once __DIR__ . '/../Service/CommandeService.php';
require_once __DIR__ . '/../Service/KeywordService.php';
require_once __DIR__ . '/../Models/UserRepository.php';
require_once __DIR__ . '/../Models/ProduitRepository.php';
require_once __DIR__ . '/../Validator/PasswordValidator.php';

class ChatService
{

    private ProduitService $produitService;
    private CategorieService $categorieService;
    private KeywordService $keywordService;
    private CommandeService $commandeService;
    private UserRepository $userRepository;
    private ProduitRepository $produitRepository;

    public function __construct(){
        $this->produitService  = new ProduitService();
        $this->categorieService  = new CategorieService();
        $this->keywordService  = new KeywordService();
        $this->commandeService  = new CommandeService();
        $this->userRepository  = new UserRepository();
        $this->produitRepository = new ProduitRepository();

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
            if (!empty($_SESSION['action']) && $_SESSION['action'] === 1){
                $response = $this->isKeyword($sentences);
            }
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
            case 'add' :{
                    if (isset($_SESSION['product'])){
                        $produit = $this->produitRepository->getProductById($_SESSION['product']);
                        if (empty($produit) ) {
                            $response = 'le produit n\'est pas reconnue veuillez ressayer ';
                        }elseif (isset($_SESSION['panier']) && array_search($produit['id'],$_SESSION['panier']) ){
                            $response = 'le produit a dèjà été ajouter au panier';
                            unset($_SESSION['lastkeyword']);
                        } else {
                            $_SESSION['panier'] []= $produit['id'];
                            $response = 'Le produit '. $produit['produit']. ' a été ajouter au panier';
                            unset($_SESSION['lastkeyword']);
                        }
                    } else {
                        $response = 'Quelle produit rechercher-vous ?';
                        $_SESSION['lastkeyword'] = 'product';
                    }
                break;
            }
            case 'see' : {
                if (!empty($_SESSION['panier'])){
                    $response = 'Voici le contenue de votre panier(pour suppirmer un produit du panier taper \'supprimer du panier\')';
                    foreach ($_SESSION['panier'] as $id){
                        $produit = $this->produitRepository->getProductById($id);
                        $response = $response . '<br>' . $produit['produit'] . 'référence produit : ' . $produit['ref'] ;
                    }
                } else {
                    $response = 'Votre panier est vide';
                }
                unset($_SESSION['lastkeyword']);
                break;
            }
            case 'delete' : {
                if (empty($_SESSION['panier'])){
                    $response = 'votre panier est vide';
                } elseif(empty($this->produitRepository->getProductByRef($sentences)) || array_search($this->produitRepository->getProductByRef($sentences)['ref'], $_SESSION['panier'])){
                    $response = 'le produit demander n\'existe pas veuillez véfiez en tappant \'voir panier\'';
                } else{
                    unset($_SESSION['panier'][array_search($this->produitRepository->getProductByRef($sentences)['ref'], $_SESSION['panier'])]);
                    if (empty($_SESSION['panier'])){
                        $response = 'Votre panier est maintenant vide';
                    } else {
                        $response = 'l\'élément a bien été supprimer du panier taper \'voir le panier\' afin de visualisé le panier';
                    }
                }
                unset($_SESSION['lastkeyword']);
                break;
            }
            case 'commande' : {
                switch ($sentences){
                    case 'oui': {
                        if (!empty($_SESSION['panier'])){
                            $response = 'Voici le contenue de votre panier(pour suppirmer un produit du panier taper \'supprimer du panier\')';
                            foreach ($_SESSION['panier'] as $id){
                                $produit = $this->produitRepository->getProductById($id);
                                $response = $response . '<br>' . $produit['produit'] . 'référence produit : ' . $produit['ref'] ;
                            }
                            $_SESSION['lastkeyword'] = 'commande_confirme';
                            $response = $response . '<br/>renseigner votre addresse mail si après et envoyé un chéques aux coordonnée suivantes vous recevrez votre commande dans les plus bref délaie vous serez tenu au courant par mail';
                        } else {
                            $response = 'Votre panier est vide Vous ne pouvez prien commander pour ajouter un produit au panier tapez ajoutez au panier';
                        }
                        break;
                    }
                    case 'non':
                        $response = 'Procéssus de commande abandonées';
                        unset($_SESSION['lastkeyword']);
                        break;
                    default :
                        $response = 'je n\'ai pas comrpis votre réponse taper oui ou non';
                        break;
                }
                break;
            }
            case 'commande_confirm' : {
                $_SESSION['email'] = $sentences;
                if (!$this->commandeService->addCommande()){
                    $response = 'Un problème est survenue dans l\'enregistrement de votre commande veuillez réessayer';
                } else{
                    $response = 'Votre commande a été enregistrer si nous ne recevons pas le chèque dans un delaie de 30 jours elle sera abandonné, Merci de votre commande a bientôt';
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
        if (isset($_SESSION['lastkeyword'])){
            unset($_SESSION['lastkeyword']);
        }
        if (isset($_SESSION['product'])){
            unset($_SESSION['product']);
        }
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