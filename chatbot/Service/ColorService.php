<?php

namespace Chatbot\Service;
require_once __DIR__ . '/../Models/ColorRepository.php';
require_once __DIR__ . '/../DataBase/dbConnection.php';
require_once __DIR__ . '/../Entity/Color.php';

use Chatbot\Repository\ColorRepository;
use Chatbot\Database\dbConnection;
use Chatbot\Entity\Color;

class ColorService
{
    private ColorRepository $repository;

    public function __construct(){
        $this->repository = new ColorRepository( new dbConnection() );
    }

    /**
     * Valide la sélection de la palette de couleur du chatbot
     * @param int $id
     * @return void
     */
    public function usePalette() 
    {
        $id = intval($_POST['id']);
        $this->repository->editPalette($id);
        $this->repository->updateActivePalette($id);
    }
}