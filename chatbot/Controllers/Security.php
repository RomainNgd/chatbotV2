<?php

namespace Chatbot\Controllers;
use Chatbot\Repository\UserRepository;

class Security
{

    public static function secureHTML($chaine): string
    {
        return htmlentities($chaine);
    }

    public static function estConnecte(): bool
    {
        return !empty($_SESSION['chatuser']);
    }

    public static function estAdministrateur(): bool
    {
        return ($_SESSION['chatUser']['role'] === 'admin');
    }

    public static function isFirstConnection() : bool
    {
        $repository = new UserRepository();
        return $repository->alreadyConnected();
    }
}