<?php


use Chatbot\Controllers\AdminController;
use Chatbot\Controllers\MainController;
use Chatbot\Controllers\Security;
use Chatbot\Controllers\Toolbox;
use Chatbot\Service\AdminService;
use Chatbot\Service\StarterService;
use Validator\PasswordValidator;

session_start();


define("URL", str_replace("index.php", "", (isset($_SERVER['HTTPS']) ? "https" : "http") .
    "://" . $_SERVER['HTTP_HOST'] . $_SERVER["PHP_SELF"]));
require_once 'Controllers/AdminController.php';
require_once 'Controllers/MainController.php';
require_once 'Service/AdminService.php';
require_once 'Service/StarterService.php';
require_once 'Controllers/Security.php';
require_once 'Controllers/Toolbox.php';
require_once 'Validator/PasswordValidator.php';

$adminController = new AdminController();
$mainController = new MainController();
$adminService = new AdminService();
$starterService = new StarterService();


try {
    if (empty($_GET['page'])) {
        $page = "admin";
    } else {
        $url = explode("/", filter_var($_GET['page'], FILTER_SANITIZE_URL));
        $page = $url[0];
    }
    switch ($page) {
        case 'starter':
            if (Security::isFirstConnection()){
                header("Location:" . URL . "login");
            } else {
                $adminController->starter();
            }
            break;
        case 'validateStarter' :
            if (Security::isFirstConnection()){
                header("Location:" . URL . "login");
            } else {
                if (!empty($_POST['admin-id']) && !empty($_POST['admin-password']) && !empty($_POST['admin-password-confirm'])) {
                    if (!PasswordValidator::validPassword($_POST['admin-password'])) {
                        header("Location:" . URL . "starter");
                    } else {
                        if ($starterService->validateStarter()) {
                            header("Location:" . URL . "login");
                        } else {
                            Toolbox::ajouterMessageAlerte("Une erreur est survenue", Toolbox::COULEUR_ROUGE);
                            header("Location:" . URL . "starter");
                        };
                    }
                } else {
                    Toolbox::ajouterMessageAlerte("Veuillez completer tout les champs !", Toolbox::COULEUR_ROUGE);
                    header("Location:" . URL . "admin");
                }
            }
            break;
        case 'admin':
            if (!Security::estConnecte()) {
                if (!Security::isFirstConnection()){
                    header("Location:" . URL . "starter");
                } else{
                    Toolbox::ajouterMessageAlerte("Veuillez vous connecter !", Toolbox::COULEUR_ROUGE);
                    header("Location:" . URL . "login");
                }
            }else{
                if (empty($url[1])){
                    $adminController->admin();
                } else {
                    switch ($url[1]){
                        case 'accueil':
                            $adminController->admin();
                            break;
                        case 'user':
                            if (empty($url[2])){
                                $adminController->user();
                            } else {
                                switch ($url[2]){
                                    case 'new':
                                        break;
                                    case 'edit':
                                        break;
                                    case 'validateEdit':
                                        break;
                                    case 'delete':
                                        break;
                                    default :
                                        $mainController->pageErreur('Cette page n\'existe pas');
                                        break;
                                }
                            }
                        case 'keyword' :
                            if (empty($url[2])){
                                $adminController->keyword();
                            } else {
                                switch ($url[2]){
                                    case 'new':
                                        if (!empty($_POST['response']) && !empty($_POST['keyword-1']) && !empty($_POST['priority-1'])){
                                            if ($adminService->validateResponse()){
                                                Toolbox::ajouterMessageAlerte(
                                                    "Le réponse et ses mots clée ont bien été ajoutés",
                                                    Toolbox::COULEUR_VERTE
                                                );
                                            } else {
                                                Toolbox::ajouterMessageAlerte(
                                                    "Un problème est survenue veuillez réessayer",
                                                    Toolbox::COULEUR_ROUGE
                                                );
                                            }
                                        } else {
                                            Toolbox::ajouterMessageAlerte(
                                                "Veuillez completer tout les champs",
                                                Toolbox::COULEUR_ROUGE
                                            );
                                        }
                                        header("Location:" . URL . "admin/keyword");
                                        break;
                                    case 'edit':
                                        if (!isset($_GET['id']) && is_int($_GET['id'])){
                                            Toolbox::ajouterMessageAlerte(
                                                "Veuillez effectuer l'action normalement",
                                                Toolbox::COULEUR_ROUGE
                                            );
                                            header("Location:" . URL . "admin/keyword");
                                        } else {
                                            $adminController->editResponse();
                                        }
                                        break;
                                    case 'validateEdit' :
                                        if (!empty($_POST['response']) && !empty($_POST['keyword-1']) && !empty($_POST['priority-1'])  && !empty($_POST['response-id']) && !empty($_POST['k-id-1']) && !empty($_POST['k-length']) && !empty($_POST['k-length-new'])){
                                            if ($adminService->editValidateResponse()){
                                                Toolbox::ajouterMessageAlerte(
                                                    "Le réponse et ses mots clée ont bien été modifié",
                                                    Toolbox::COULEUR_VERTE
                                                );
                                                header("Location:" . URL . "admin/keyword");
                                            } else {
                                                header("Location:" . URL . "admin/keyword/edit&id=" . $_POST['response-id']);
                                            }
                                        } else {
                                            Toolbox::ajouterMessageAlerte(
                                                "Veuillez completer tout les champs",
                                                Toolbox::COULEUR_ROUGE
                                            );
                                            header("Location:" . URL . "admin/keyword/edit&id=" . $_POST['response-id']);
                                        }
                                        break;
                                    case 'delete':
                                        if (!empty($_GET['id'])){
                                            if ($adminService->deleteResponse()){
                                                Toolbox::ajouterMessageAlerte(
                                                    "Le produit a bien été supprimé",
                                                    Toolbox::COULEUR_VERTE
                                                );
                                            } else {
                                                Toolbox::ajouterMessageAlerte(
                                                    "Un problème est survenue veuillez réessayer",
                                                    Toolbox::COULEUR_ROUGE
                                                );
                                            }
                                        } else {
                                            Toolbox::ajouterMessageAlerte(
                                                "Veuillez effectuer l'action normalement",
                                                Toolbox::COULEUR_ROUGE
                                            );
                                        }
                                        header("Location:" . URL . "admin/keyword");
                                        break;

                                    default :
                                        $mainController->pageErreur('Cette page n\'existe pas');
                                }
                            }
                            break;
                        case 'produit':
                            if (empty($url[2])){
                                $adminController->product();
                            } else {
                                switch ($url[2]){
                                    case 'new':
                                        if (!empty($_POST['name']) && !empty($_POST['ref']) && !empty($_POST['slug']) && !empty($_POST['price']) && !empty($_POST['category'])){
                                            if ($adminService->validateProduct()){
                                                Toolbox::ajouterMessageAlerte(
                                                    "Le réponse et ses mots clée ont bien été modifié",
                                                    Toolbox::COULEUR_VERTE);
                                            } else {
                                                Toolbox::ajouterMessageAlerte(
                                                    "Un problème est survenue veuillez réessayer",
                                                    Toolbox::COULEUR_ROUGE
                                                );
                                            }
                                        } else {
                                            Toolbox::ajouterMessageAlerte(
                                                "Veuillez completer tout les champs" . var_dump($_POST),
                                                Toolbox::COULEUR_ROUGE
                                            );
                                        }
                                        header("Location:" . URL . "admin/produit");
                                        break;
                                    case 'edit':
                                        if (!isset($_GET['id']) && is_int($_GET['id'])){
                                            Toolbox::ajouterMessageAlerte(
                                                "Veuillez effectuer l'action normalement",
                                                Toolbox::COULEUR_ROUGE
                                            );
                                            header("Location:" . URL . "admin/produit");
                                        } else {
                                            $adminController->editProduct();
                                        }
                                        break;
                                    case 'validateEdit':
                                        if (!empty($_POST['name']) && !empty($_POST['price']) && !empty($_POST['ref'])  && !empty($_POST['slug']) && !empty($_POST['category']) && !empty($_POST['id'])){
                                            if ($adminService->editValidateProduct()){
                                                Toolbox::ajouterMessageAlerte(
                                                    "Le produit a bien été modifié",
                                                    Toolbox::COULEUR_VERTE
                                                );
                                            } else {
                                                Toolbox::ajouterMessageAlerte(
                                                    "Un problème est survenue veuillez réessayer",
                                                    Toolbox::COULEUR_ROUGE
                                                );
                                            }
                                        } else {
                                            Toolbox::ajouterMessageAlerte(
                                                "Veuillez completer tout les champs",
                                                Toolbox::COULEUR_ROUGE
                                            );
                                        }
                                        header("Location:" . URL . "admin/produit");
                                        break;
                                    case "delete":
                                        if (!empty($_GET['id'])){
                                            if ($adminService->deleteProduct()){
                                                Toolbox::ajouterMessageAlerte(
                                                    "Le produit a bien été supprimé",
                                                    Toolbox::COULEUR_VERTE
                                                );
                                            } else {
                                                Toolbox::ajouterMessageAlerte(
                                                    "Un problème est survenue veuillez réessayer",
                                                    Toolbox::COULEUR_ROUGE
                                                );
                                            }
                                        } else {
                                            Toolbox::ajouterMessageAlerte(
                                                "Un problème est survenue veuillez réessayer",
                                                Toolbox::COULEUR_ROUGE
                                            );
                                        }
                                        header("Location:" . URL . "admin/produit");
                                        break;
                                    default :
                                        $mainController->pageErreur('Cette page n\'existe pas');
                                        break;
                                }
                            }
                            break;
                        case 'categorie':
                            if (empty($url[2])){
                                $adminController->category();
                            } else {
                                switch ($url[2]){
                                    case 'new':
                                        if (!empty($_POST['categorie']) && !empty($_POST['slug'])){
                                            if ($adminService->validateCategory()){
                                                Toolbox::ajouterMessageAlerte(
                                                    "La categorie a bine été ajouté",
                                                    Toolbox::COULEUR_VERTE);
                                            } else {
                                                Toolbox::ajouterMessageAlerte(
                                                    "Un problème est survenue veuillez réessayer",
                                                    Toolbox::COULEUR_ROUGE
                                                );
                                            }
                                        } else {
                                            Toolbox::ajouterMessageAlerte(
                                                "Veuillez completer tout les champs",
                                                Toolbox::COULEUR_ROUGE
                                            );
                                        }
                                        header("Location:" . URL . "admin/categorie");
                                        break;
                                    case 'edit':
                                        if (!isset($_GET['id']) && is_int($_GET['id'])){
                                            Toolbox::ajouterMessageAlerte(
                                                "Veuillez effectuer l'action normalement",
                                                Toolbox::COULEUR_ROUGE
                                            );
                                            header("Location:" . URL . "admin/categorie");
                                        } else {
                                            $adminController->editCategory();
                                        }
                                        break;
                                    case 'validateEdit':
                                        if (!empty($_POST['categorie']) && !empty($_POST['slug']) && !empty($_POST['id'])){
                                            if ($adminService->editValidateCategory()){
                                                Toolbox::ajouterMessageAlerte(
                                                    "La Categorie a bien été modifié",
                                                    Toolbox::COULEUR_VERTE
                                                );
                                            } else {
                                                Toolbox::ajouterMessageAlerte(
                                                    "Un problème est survenue veuillez réessayer",
                                                    Toolbox::COULEUR_ROUGE
                                                );
                                            }
                                        } else {
                                            Toolbox::ajouterMessageAlerte(
                                                "Veuillez completer tout les champs",
                                                Toolbox::COULEUR_ROUGE
                                            );
                                        }
                                        header("Location:" . URL . "admin/categorie");
                                        break;
                                    case 'delete':
                                        if (!empty($_GET['id'])){
                                            if ($adminService->deleteCategory()){
                                                Toolbox::ajouterMessageAlerte(
                                                    "La Categorie a bien été supprimer",
                                                    Toolbox::COULEUR_VERTE
                                                );
                                            } else {
                                                Toolbox::ajouterMessageAlerte(
                                                    "Un problème est survenue veuillez réessayer",
                                                    Toolbox::COULEUR_ROUGE
                                                );
                                            }
                                        } else {
                                            Toolbox::ajouterMessageAlerte(
                                                "Un problème est survenue veuillez réessayer",
                                                Toolbox::COULEUR_ROUGE
                                            );
                                        }
                                        header("Location:" . URL . "admin/categorie");
                                        break;
                                }
                            }
                            break;
                        default:
                            $mainController->pageErreur('Cette page n\'existe pas');
                            break;
                    }
                }
            }
            break;
        case 'login':
            if (Security::estConnecte()){
                header("Location:" . URL . "admin");
            } else {
                $adminController->login();
            }
            break;
        case 'validationlogin':
            if (!empty($_POST['login']) && !empty($_POST['password'])) {
                $login = Security::secureHTML($_POST['login']);
                $password = Security::secureHTML($_POST['password']);
                $adminController->validationLogin($login, $password);
            } else {
                Toolbox::ajouterMessageAlerte(
                    "Login ou mot de passe non renseigné",
                    Toolbox::COULEUR_ROUGE
                );
                header('Location:' . URL . "login");
            }
            break;
        case 'deconnexion':
            $adminController->logout();
            break;
        default :
            $mainController->pageErreur('Cette page n\'existe pas');

    }
} catch (Exception $e) {
    $mainController->pageErreur($e->getMessage());
}