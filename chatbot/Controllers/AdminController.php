<?php
namespace Chatbot\Controllers;

use Chatbot\Repository\CategorieRepository;
use Chatbot\Repository\KeywordRepository;
use Chatbot\Repository\ProduitRepository;
use Chatbot\Repository\ResponseRepository;
use chatbot\Repository\UserRepository;
use Chatbot\Repository\ColorRepository;
use Chatbot\Repository\CommandeRepository;
use Chatbot\Service\AdminService;

require_once("MainController.php");
require_once (__DIR__ . '/../Models/UserRepository.php');
require_once (__DIR__ . '/../Models/ResponseRepository.php');
require_once (__DIR__ . '/../Models/KeywordRepository.php');
require_once (__DIR__ . '/../Models/ProduitRepository.php');
require_once (__DIR__ . '/../Models/CategorieRepository.php');
require_once (__DIR__ . '/../Models/ColorRepository.php');
require_once (__DIR__ . '/../Models/CommandeRepository.php');
require_once (__DIR__ . '/../Service/AdminService.php');


class AdminController extends MainController
{
    private UserRepository $userRepository;
    private ResponseRepository $responseRepository;
    private KeywordRepository $keywordRepository;
    private ProduitRepository $produitRepository;
    private CategorieRepository $categorieRepository;
    private ColorRepository $colorRepository;
    private CommandeRepository $commandeRepository;

    public function __construct()
    {
       $this->userRepository = new UserRepository();
       $this->responseRepository = new ResponseRepository();
       $this->keywordRepository = new KeywordRepository();
       $this->produitRepository = new ProduitRepository();
       $this->categorieRepository = new CategorieRepository();
       $this->colorRepository = new ColorRepository();
       $this->commandeRepository = new CommandeRepository();
    }

    public function login(){

        $data_page = [
            'page_description' => 'page d\'accueil des visiteur',
            'page_title' => 'page de login',
            'views' => 'Views/connexion.view.php',
            'template' => 'Views/partials/template.php',
            'page_css' => ['style.css', 'admin.css'],

        ];
        $this->genererPage($data_page);
    }

    public function validationLogin($login, $password): void
    {
        if($this->userRepository->isCombinaisonValid($login, $password)){
            Toolbox::ajouterMessageAlerte(
                "La connexion a resussi, Bon retour parmi nous !",
                Toolbox::COULEUR_VERTE
            );
            $this->userRepository->setLastConnection($login);
            $_SESSION['chatuser'] = [
                'login' => $login
            ];
            header('Location:' .URL."admin");
        }else{
            Toolbox::ajouterMessageAlerte(
                "Combinaison login /mot de passe valide !",
                Toolbox::COULEUR_ROUGE
            );
            header('Location:'.URL."login");
        }
    }

    public function admin()
    {
        $data_page = [
            'page_description' => 'page d\'administration du bot',
            'page_title' => 'page admin',
            'views' => 'views/adminInterface.view.php',
            'template' => 'views/partials/template.php',
            'page_css' => ['admin.css'],
            'page_menu' => 'accueil'
        ];
        $this->genererPage($data_page);
    }

    public function keyword(){

        $responses = $this->responseRepository->getAllResponse();
        $array = [];
        foreach ($responses as $response){
            $array[] = [$response['response'] => $this->keywordRepository->getKeywordAsResponse($response[0])];
        }

        $data_page = [
            'page_description' => 'Gestion des réponses et mot clée',
            'page_title' => 'page de réponse',
            'views' => 'Views/response/keyword.view.php',
            'template' => 'Views/partials/template.php',
            'page_javascript' => ['newKeyword.js'],
            'page_css' => ['newKeyword.css' ,'admin.css', 'table.css', 'popup.css'],
            'list' => $array,
            'id' => $responses,
            'page_menu' => 'keyword'
        ];
        $this->genererPage($data_page);
    }

    public function product(){
        $products = $this->produitRepository->getAllProduct();
        $categories = $this->categorieRepository->getAllCategories();

        $data_page = [
            'page_description' => 'Gestion des produits',
            'page_title' => 'page de produit',
            'views' => 'Views/product/product.view.php',
            'template' => 'Views/partials/template.php',
            'page_javascript' => ['popup.js'],
            'page_css' => ['product.css' ,'admin.css', 'table.css', 'popup.css'],
            'list' => $products,
            'categories' => $categories,
            'page_menu' => 'produit'
        ];
        $this->genererPage($data_page);
    }

    public function color(){
        $palette = $this->colorRepository->getPalette();

        $data_page= [
            'page_description' => 'Gestion des couleurs',
            'page_title' => 'page de couleur',
            'views' => 'Views/color/color.view.php',
            'template' => 'Views/partials/template.php',
            'page_javascript' => ['popup.js'],
            'page_css' => ['color.css' ,'admin.css', 'table.css', 'popup.css'],
            'list' => $palette,
            'page_menu' => 'color'
        ];
        $this->genererPage($data_page);
    }

    public function commande(){
        $commande = $this->commandeRepository->getAll();

        $data_page= [
            'page_description' => 'Gestion des commande',
            'page_title' => 'page de commande',
            'views' => 'Views/commande/commande.view.php',
            'template' => 'Views/partials/template.php',
            'page_javascript' => ['popup.js', 'commande.js'],
            'page_css' => ['admin.css', 'table.css', 'popup.css', 'commande.css'],
            'list' => $commande,
            'page_menu' => 'color'
        ];
        $this->genererPage($data_page);
    }

    public function editProduct(){
        $product = $this->produitRepository->getProductById($_GET['id']);
        $categories = $this->categorieRepository->getAllCategories();

        if (!$product){
            $this->pageErreur('Cette page n\'existe pas');
        }

        $data_page = [
            'page_description' => 'Gestion des produits',
            'page_title' => 'page de produit',
            'views' => 'Views/product/editProduct.view.php',
            'template' => 'Views/partials/template.php',
            'page_javascript' => ['popup.js'],
            'page_css' => ['product.css' ,'admin.css', 'table.css'],
            'product' => $product,
            'categories' => $categories,
            'page_menu' => 'produit'
        ];
        $this->genererPage($data_page);
    }

    public function editResponse(){
        $response = $this->responseRepository->getOneResponse($_GET['id']);
        $keywords = $this->keywordRepository->getKeywordAsResponse($_GET['id']);

        if (!$response){
            $this->pageErreur('Cette page n\'existe pas');
        }
        $data_page = [
            'page_description' => 'Gestion des produits',
            'page_title' => 'page de produit',
            'views' => 'Views/response/editKeyword.view.php',
            'template' => 'Views/partials/template.php',
            'page_javascript' => ['editKeyword.js'],
            'page_css' => ['newKeyword.css' ,'admin.css', 'table.css'],
            'response' => $response,
            'keywords' => $keywords,
            'page_menu' => 'keyword'
        ];
        $this->genererPage($data_page);
    }

    public function category(){

        $categories = $this->categorieRepository->getAllCategories();
        $data_page = [
            'page_description' => 'Gestion des produits',
            'page_title' => 'page de produit',
            'views' => 'Views/category/categorie.view.php',
            'template' => 'Views/partials/template.php',
            'page_javascript' => ['popup.js'],
            'page_css' => ['product.css' ,'admin.css', 'table.css', 'popup.css'],
            'page_menu' => 'categorie',
            'list' => $categories,
        ];
        $this->genererPage($data_page);
    }
    public function editCategory(){

        $category = $this->categorieRepository->getCategorieById($_GET['id']);
        if (!$category){
            $this->pageErreur('Cette page n\'existe pas');
        }
        $data_page = [
            'page_description' => 'Edition de categorie',
            'page_title' => 'Edition d\'une categorie',
            'views' => 'Views/category/editCategory.view.php',
            'template' => 'Views/partials/template.php',
            'page_javascript' => ['popup.js'],
            'page_css' => ['product.css' ,'admin.css', 'table.css'],
            'category' => $category,
            'page_menu' => 'categorie'
        ];
        $this->genererPage($data_page);
    }

    public function starter(){
        $data_page = [
            'page_description' => 'Configuration du chatbot',
            'page_title' => 'configuration du chatbot',
            'views' => 'Views/starter.view.php',
            'template' => 'Views/partials/template.php',
            'page_javascript' => ['starter.js'],
            'page_css' => ['starter.css'],
        ];
        $this->genererPage($data_page);
    }


    public function logout(){
        Toolbox::ajouterMessageAlerte('la deconnexion a bine été effectué', Toolbox::COULEUR_VERTE);
        unset($_SESSION['chatuser']);
        header('Location: '.URL.'login');
    }
}