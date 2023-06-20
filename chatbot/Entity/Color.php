<?php

namespace Chatbot\Entity;

class Color
{
    private int $id;

    public function __construct(){
        
    }

    // public function setPalette(int $palette): void{
    //     $this->palette = $palette;
    // }

    // public function getPalette(): array
    // {
    //     return $this->palette;
    // }

    /**
     * @param int $id
     * @return void
     */

    public function setId(int $id): void{
        $this->id = $id;
    }

    public function getId(): int{
        return $this->id;
    }
}