<?php

namespace Chatbot\Service;

require_once __DIR__ . '/../Models/UserRepository.php';

use Chatbot\Controllers\Toolbox;
use Chatbot\Repository\UserRepository;

class StarterService
{

    private UserRepository $userRepository;

    public function __construct(){
        $this->userRepository = new UserRepository();
    }

    public function validateStarter() : bool{

        if (!$this->updateUser($_POST['admin-id'], $_POST['admin-password'], $_POST['admin-password-confirm'])){
            return false;
        } else {
            return true;
        }
    }


    private function updateUser($id, $password, $confirmPassword): bool{
        if ($password === $confirmPassword){
            $passwordCrypt = password_hash($password, PASSWORD_DEFAULT);
            try{
                $this->userRepository->updateUser($id, $passwordCrypt);
            } catch (\Exception $e){
                Toolbox::ajouterMessageAlerte("Un problème est survenue", Toolbox::COULEUR_ROUGE);
                return false;
            }
        } else{
            Toolbox::ajouterMessageAlerte("Les mot de passe ne sont pas similaire", Toolbox::COULEUR_ROUGE);
            return false;
        }
        return true;
    }

}