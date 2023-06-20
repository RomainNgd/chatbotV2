<?php

namespace Chatbot\Service;

require_once __DIR__ . '/../Models/ProduitRepository.php';
require_once __DIR__ . '/../Models/CommandeRepository.php';
require_once __DIR__ . '/../Entity/Commande.php';

use Chatbot\Entity\Commande;
use Chatbot\Repository\ProduitRepository;
use Chatbot\Repository\CommandeRepository;

class CommandeService
{

    private ProduitRepository $produitRepository;
    private CommandeRepository $commandeRepository;

    public function __construct(){
        $this->produitRepository = new ProduitRepository();
        $this->commandeRepository = new CommandeRepository();
    }

    public function addCommande(): bool{
        $commande = new Commande();
        $commande->setCreateAt(new \DateTime());
        $commande->setEmail($_SESSION['email']);
        $product = '';
        foreach ($_SESSION['panier'] as $item) {
            $product = $product . $this->produitRepository->getProductById($item)['ref'] . ' , ';
        }
        $commande->setProduct($product);

        try{
            $this->commandeRepository->newCommande($commande);
            return true;
        } catch (\Exception $e){
            return false;
        }
    }

    public function setStatus(int $id, string $status): bool{
        $commande = new Commande();
        $commande->setId($id);
        switch ($status){
            case 'call':
                $commande->setStatus(Commande::STATUSSENT);
            case 'sent':
                $commande->setStatus(Commande::STATUSSENT);
            case 'payed':
                $commande->setStatus(Commande::STATUSRECEIVE);
        }
        try {
            $this->commandeRepository->setStatus($commande);
            return true;
        } catch (\Exception $e){
            return false;
        }


    }
}