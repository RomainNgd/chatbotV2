<?php

namespace Chatbot\Entity;

class Produit
{
    private const URLTYPE = 'default';

    private int $id;

    private string $produit;

    private float $prix;

    private string $slug;

    private string $url;

    private string $ref;

    private int $categorie;

    public function __construct()
    {
    }

    /**
     * @return string
     */
    public function getProduit(): string
    {
        return $this->produit;
    }

    /**
     * @param string $produit
     */
    public function setProduit(string $produit): void
    {
        $this->produit = $produit;
    }

    /**
     * @return float
     */
    public function getPrix(): float
    {
        return $this->prix;
    }

    /**
     * @param float $prix
     */
    public function setPrix(float $prix): void
    {
        $this->prix = $prix;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
        $this->setUrl(self::URLTYPE . $slug);
    }

    /**
     * @return int
     */
    public function getCategorie(): int
    {
        return $this->categorie;
    }

    /**
     * @param int $categorie
     */
    public function setCategorie(int $categorie): void
    {
        $this->categorie = $categorie;
    }

    /**
     * @return string
     */
    public function getRef(): string
    {
        return $this->ref;
    }

    /**
     * @param string $ref
     */
    public function setRef(string $ref): void
    {
        $this->ref = $ref;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }
}