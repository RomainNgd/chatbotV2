<?php

namespace Validator;

use Chatbot\Controllers\Toolbox;
class PasswordValidator
{

    public function __construct(){
    }

    public static function validPassword (string $password) :bool{
        if (strlen($password) < 8 ){
            Toolbox::ajouterMessageAlerte('Le mot de passe doit contenir 8 caractère', Toolbox::COULEUR_ROUGE);
            return false;
        } elseif (!preg_match('/[A-Z]/', $password)){
            Toolbox::ajouterMessageAlerte('Le mot de passe doit contenir une majuscule', Toolbox::COULEUR_ROUGE);
            return false;
        }elseif (!preg_match('/[a-z]/', $password)){
            Toolbox::ajouterMessageAlerte('Le mot de passe doit contenir une minuscule', Toolbox::COULEUR_ROUGE);
            return false;
        }elseif (!preg_match('/\d/', $password)){
            Toolbox::ajouterMessageAlerte('Le mot de passe doit contenir un chiffre', Toolbox::COULEUR_ROUGE);
            return false;
        } else{
            return true;
        }
    }

}