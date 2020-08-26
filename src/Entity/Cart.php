<?php

namespace App\Entity;

use App\Repository\CartRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * @ORM\Entity(repositoryClass=CartRepository::class)
 */
class Cart
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float", name="total_price")
     */
    private $totalPrice = 0.0;

    /**
     * @ORM\Column(type="datetime", name="created_at")
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity=CartProduct::class, mappedBy="cart")
     */
    private $cartProducts;

    public function __construct()
    {
        $this->cartProducts = new ArrayCollection();
        $this->createdAt = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTotalPrice(): float
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(float $totalPrice): self
    {
        $this->totalPrice += $totalPrice;

        return $this;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection|CartProduct[]
     */
    public function getCartProducts()
    {
        return $this->cartProducts;
    }

    public function addProduct(CartProduct $cartProduct)
    {
        if (!$this->cartProducts->contains($cartProduct)) {
            $this->cartProducts[] = $cartProduct;
        }

        return $this;
    }

    public function removeProduct(CartProduct $cartProduct)
    {
        if (!$this->cartProducts->contains($cartProduct)) {
            return $this;
        }

        $this->cartProducts->removeElement($cartProduct);
        $this->setTotalPrice(-$cartProduct->getProduct()->getPrice());
        return $this;
    }
}
