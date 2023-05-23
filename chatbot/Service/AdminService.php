<?php

namespace Chatbot\Service;

require_once (__DIR__ . '/../Models/ResponseRepository.php');
require_once (__DIR__ . '/../Models/KeywordRepository.php');
require_once (__DIR__ . '/../Models/ProduitRepository.php');
require_once (__DIR__ . '/../Models/CategorieRepository.php');
require_once (__DIR__ . '/../Entity/Keyword.php');
require_once (__DIR__ . '/../Entity/Response.php');
require_once (__DIR__ . '/../Entity/Produit.php');
require_once (__DIR__ . '/../Entity/Categorie.php');

use Chatbot\Controllers\Toolbox;
use Chatbot\Entity\Categorie;
use Chatbot\Entity\Keyword;
use Chatbot\Entity\Produit;
use Chatbot\Entity\Response;
use Chatbot\Repository\CategorieRepository;
use Chatbot\Repository\KeywordRepository;
use Chatbot\Repository\ProduitRepository;
use Chatbot\Repository\ResponseRepository;
use mysql_xdevapi\Exception;

class AdminService
{
    private ResponseRepository $responseRepository;
    private KeywordRepository $keywordRepository;
    private ProduitRepository $produitRepository;
    private CategorieRepository $categorieRepository;

    public function __construct(){
        $this->responseRepository = new ResponseRepository();
        $this->keywordRepository = new KeywordRepository();
        $this->produitRepository = new ProduitRepository();
        $this->categorieRepository = new CategorieRepository();
    }


    public function validateResponse() : bool{
        $response = new Response();
        $response->setResponse($_POST['response']);
        try {
            $this->responseRepository->addResponse($response);
        } catch (\Exception $e){
            return 'un problème est survenue';
        }
        $responseId = $this->responseRepository->getResponseId($response->getResponse());
        $response->setId($responseId['id']);
        $keywordLenght = (count($_POST) - 1) / 2;
        for ($i = 1 ; $i <= $keywordLenght ; $i++){
            if (!empty($_POST['keyword-' . $i]) && !empty($_POST['priority-' . $i])){
                $keyword = new Keyword();
                $keyword->setKeyword($_POST['keyword-' . $i]);
                $keyword->setPriority($_POST['priority-' . $i]);
                $keyword->setResponse($response);
                if ($this->keywordRepository->checkKeywordExistsForAdd($keyword)){
                    $this->responseRepository->removeResponse($responseId['id']);
                    Toolbox::ajouterMessageAlerte(
                        "Un des mot clée existe déjà",
                        Toolbox::COULEUR_ROUGE
                    );
                    return false;
                }
                try {
                    $this->keywordRepository->addKeyword($keyword);
                } catch (\Exception $e){
                    return false ;
                }
            }
        }
        return true;
    }

    public function editValidateResponse():bool{
        $response = new Response();
        $response->setResponse($_POST['response']);
        $response->setId($_POST['response-id']);
        try {
            $this->responseRepository->updateResponse($response);
        } catch (\Exception $e){
            Toolbox::ajouterMessageAlerte(
                "Un problème est survenue veuillez réessayer",
                Toolbox::COULEUR_ROUGE
            );
        }
        for ($i =1; $i <= $_POST['k-length']; $i++){
            $keyword = new Keyword();
            $keyword->setResponse($response);
            $keyword->setId($_POST['k-id-'.$i]);
            $keyword->setKeyword($_POST['keyword-' . $i]);
            $keyword->setPriority($_POST['priority-'.$i]);
            if (($keyword->getKeyword() === '') or $keyword->getPriority() === null){
                Toolbox::ajouterMessageAlerte(
                    "Veuillez completer tout les champs",
                    Toolbox::COULEUR_ROUGE
                );
                return false;
            }
            if ($this->keywordRepository->checkKeywordExistsForEdit($keyword)){
                Toolbox::ajouterMessageAlerte(
                    "Un des mot clée existe deja ",
                    Toolbox::COULEUR_ROUGE
                );
                return false;
            }
            try{
                $this->keywordRepository->updateKeyword($keyword);
            } catch (\Exception $e){
                Toolbox::ajouterMessageAlerte(
                    "Un problème est survenue veuillez réessayer",
                    Toolbox::COULEUR_ROUGE
                );
                return false;
            }
        }
        for ($i = $_POST['k-length']+1; $i <= $_POST['k-length-new']; $i++){
            $keyword = new Keyword();
            $keyword->setResponse($response);
            $keyword->setKeyword($_POST['keyword-' . $i]);
            $keyword->setPriority($_POST['priority-'.$i]);
            if ($this->keywordRepository->checkKeywordExistsForAdd($keyword)){
                Toolbox::ajouterMessageAlerte(
                    "Un problème est survenue veuillez réessayer",
                    Toolbox::COULEUR_ROUGE
                );
                return false;
            }
            try{
                $this->keywordRepository->addKeyword($keyword);
            } catch (\Exception $e){
                Toolbox::ajouterMessageAlerte(
                    "Un problème est survenue veuillez réessayer",
                    Toolbox::COULEUR_ROUGE
                );
                return false;
            }
        }
        return true;
    }

    public function validateProduct() : bool{
        $product = new Produit();
        $product->setProduit($_POST['name']);
        $product->setPrix($_POST['price']);
        $product->setRef($_POST['ref']);
        $product->setCategorie($_POST['category']);
        $product->setSlug($_POST['slug']);

        try {
            $this->produitRepository->addProduit($product);
        } catch (Exception $e){
            return false;
        }

        return true;
    }

    public function editValidateProduct():bool{
        $product = new Produit();
        $product->setId($_POST['id']);
        $product->setProduit($_POST['name']);
        $product->setPrix($_POST['price']);
        $product->setRef($_POST['ref']);
        $product->setCategorie($_POST['category']);
        $product->setSlug($_POST['slug']);

        try {
            $this->produitRepository->updateProduit($product);
        } catch (\Exception $e){
            return false;
        }
        return true;
    }

    public function deleteResponse(){
        try {
            $this->responseRepository->removeResponse($_GET['id']);
        } catch (\Exception $e){
            return false;
        }
        return true;
    }

    public function validateCategory() :bool{
        $category = new Categorie();
        $category->setSlug($_POST['slug']);
        $category->setCategorie($_POST['categorie']);

        try {
            $this->categorieRepository->addCategorie($category);
        } catch (\Exception $e){
            return false;
        }
        return true;
    }

    public function editValidateCategory():bool{
        $category = new Categorie();
        $category->setSlug($_POST['slug']);
        $category->setCategorie($_POST['categorie']);
        $category->setId($_POST['id']);

        try {
            $this->categorieRepository->updateCategory($category);
        } catch (\Exception $e){
            return false;
        }
        return true;
    }

    public function deleteCategory(){
        try {
            $this->categorieRepository->deleteCategory($_GET['id']);
        } catch (\Exception $e){
            return false;
        }
        return true;
    }

    public function deleteProduct(){
        try {
            $this->produitRepository->removeProduit($_GET['id']);
        } catch (\Exception $e){
            return false;
        }
        return true;
    }
}