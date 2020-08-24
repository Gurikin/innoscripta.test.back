<?php


namespace App\Model;


use App\Entity\CartProduct;
use App\Entity\Product;

/**
 * Class CartProductDto
 * Represents the CartProduct object in cart list
 * @package App\Model
 */
class CartProductDto
{
    private int $id;
    private Product $product;
    private int $productCount;

    /**
     * CartProductDto constructor.
     * @param CartProduct $cartProduct
     */
    public function __construct(CartProduct $cartProduct)
    {
        $this->id = $cartProduct->getId();
        $this->product = $cartProduct->getProduct();
        $this->productCount = 1;
    }

    /**
     * @return $this
     */
    public function incrementProductCount(): self
    {
        $this->productCount++;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @return int
     */
    public function getProductCount(): int
    {
        return $this->productCount;
    }
}