<?php

namespace App\Entity;

use App\Repository\CartProductRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CartProductRepository::class)
 */
class CartProduct
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity=Cart::class, inversedBy="cartProducts", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private Cart $cart;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="addedToCarts", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private Product $product;

    /**
     * @ORM\Column(type="integer")
     */
    private int $productCount = 0;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCart(): Cart
    {
        return $this->cart;
    }

    public function setCart(Cart $cart): self
    {
        $this->cart = $cart;
//        $cart->addProduct($this);

        return $this;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): self
    {
        $this->product = $product;
        $this->incrementProductCount();
        $this->cart->setTotalPrice($product->getPrice());

        return $this;
    }

    public function removeProduct(int $productId): self
    {
        if ($this->product !== null && $this->product->getId() === $productId) {
            $this->decrementProductCount();
        }

        return $this;
    }

    public function getProductCount(): ?int
    {
        return $this->productCount;
    }

    public function incrementProductCount(): self
    {
        $this->productCount++;

        return $this;
    }

    public function decrementProductCount(): self
    {
        $this->productCount--;
        $this->productCount = $this->productCount < 0 ? 0 : $this->productCount;

        return $this;
    }
}