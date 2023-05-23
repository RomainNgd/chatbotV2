<?php

namespace Chatbot\Entity;

class Color
{
    private int $id;

    private array $palette;

    public function __construct(){
        
    }

    public function getPalette(): array
    {
        return $this->palette;
    }
}