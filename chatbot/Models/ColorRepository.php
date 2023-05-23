<?php

namespace Chatbot\Repository;

use Chatbot\Entity\Color;
use MainRepository;
use PDO;

class ColorRepository extends MainRepository
{
    public function __construct(){
        
    }

    public function getPalette(){
        $query = 'SELECT * FROM c_palette';
        $get = $this->getDataBase()->prepare($query);
        $get->execute()
        or die(print_r($this->getDataBase()->errorInfo()));
        return $get->fetchAll();
    }
}