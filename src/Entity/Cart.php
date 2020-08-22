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
    private ?int $id;

    /**
     * @ORM\Column(type="float", name="total_price")
     */
    private float $totalPrice = 0.0;

    /**
     * @ORM\Column(type="datetime", name="created_at")
     */
    private DateTimeInterface $createdAt;

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
    public function getCartProducts(): Collection
    {
        return $this->cartProducts;
    }

    public function addProduct(CartProduct $cartProduct): self
    {
        if (!$this->cartProducts->contains($cartProduct)) {
            $this->cartProducts[] = $cartProduct;
        }

//        /** @var CartProducts $cartProduct */
//        foreach ($this->cartProducts as $cartProduct) {
//            if ($cartProduct->getId() === $this->getId()) {
//                $cartProduct->incrementProductCount();
//            }
//        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if (!$this->cartProducts->contains($product)) {
            return $this;
        }

        /** @var CartProduct $cartProduct */
        foreach ($this->cartProducts as $cartProduct) {
            if ($cartProduct->getCart()->getId() === $this->getId() && $cartProduct->getProductCount() === 1) {
                $this->cartProducts->removeElement($product);
                $product->removeFromCart($this);

                return $this;
            }

            if ($cartProduct->getId() === $this->getId()) {
                $cartProduct->decrementProductCount();

                return $this;
            }
        }

        return $this;
    }
}
