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

    public function getPaletteById($id){
        $query = 'SELECT * FROM c_palette WHERE id = :id';
        $get = $this->getDataBase()->prepare($query);
        $get->bindParam(':id', $id, PDO::PARAM_INT);
        $get->execute()
        or die(print_r($this->getDataBase()->errorInfo()));
        return $get->fetch(PDO::FETCH_ASSOC);
    }

    public function editPalette($id){
        $palette = $this->getPaletteById($id);
        $file = dirname( __DIR__, 2) . '\chatbot\assets\css\palette.css';

        $data = trim("
            /* style général / variables **/
            :root{
                --light-color: " . $palette['light_color'] . ";
                --main-color: " . $palette['main_color'] . ";
                --main-dark-color: " . $palette['dark_color'] . ";
                --gray-color: " . $palette['gray_color'] . ";
            }
        ");
        $data = preg_replace('/\s+/s', ' ', $data);

        file_put_contents($file, $data); 
    }

    public function updateActivePalette($id){
        $query = "
            UPDATE c_palette SET active = 0 WHERE id != :id;
            UPDATE c_palette SET active = 1 WHERE id = :id;
        ";
        $get = $this->getDataBase()->prepare($query);
        $get->bindValue(':id', $id);
        $get->execute() or die(print_r($this->getDataBase()->errorInfo()));
    }
}