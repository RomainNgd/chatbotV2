<?php

namespace Chatbot\Entity;

class Commande
{
    private int $id;

    private string $email;

    private \DateTime $createAt;

    private array $product;

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
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return \DateTime
     */
    public function getCreateAt(): \DateTime
    {
        return $this->createAt;
    }

    /**
     * @param \DateTime $createAt
     */
    public function setCreateAt(\DateTime $createAt): void
    {
        $this->createAt = $createAt;
    }

    /**
     * @return array
     */
    public function getProduct(): array
    {
        return $this->product;
    }

    /**
     * @param array $product
     */
    public function setProduct(array $product): void
    {
        $this->product = $product;
    }

}