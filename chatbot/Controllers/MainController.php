<?php
namespace Chatbot\Controllers;
class MainController{
    public function __construct(){
    }

    protected function genererPage($data){
        extract($data);
        ob_start();
        require_once($views);
        $page_content = ob_get_clean();
        require_once($template);
    }

    //Propriété "page_css" : tableau permettant d'ajouter des fichiers CSS spécifiques
    //Propriété "page_javascript" : tableau permettant d'ajouter des fichiers JavaScript spécifiques
    public function site(){
        // Toolbox::ajouterMessageAlerte("test", Toolbox::COULEUR_VERTE);

        $data_page = [
            "page_description" => "Description de la page d'accueil",
            "page_title" => "Titre de la page d'accueil",
            "views" => "views/chatbot.php",
            "template" => "views/partials/template.php",
            'page_css' => ['style.css'],
            'page_javascript' => ['script.js']
        ];
        $this->genererPage($data_page);
    }

    public function pageErreur($msg){
        $data_page = [
            "page_description" => "Page permettant de gérer les erreurs",
            "page_title" => "Page d'erreur",
            "msg" => $msg,
            "views" => "views/erreur.view.php",
            "template" => "views/partials/template.php",
        ];
        $this->genererPage($data_page);
    }
}