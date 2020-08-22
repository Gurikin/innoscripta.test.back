<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="product", uniqueConstraints={@ORM\UniqueConstraint(name="name", columns={"name", "product_type"})}, indexes={@ORM\Index(name="product_type", columns={"product_type"})}) *
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float", precision=10, scale=0, nullable=false)
     */
    private $price;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     */
    private $description;

    /**
     * @var string|null
     *
     * @ORM\Column(name="image_url", type="string", length=255, nullable=true)
     */
    private $imageUrl;

    /**
     * @var ProductType
     *
     * @ORM\ManyToOne(targetEntity="ProductType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_type", referencedColumnName="id")
     * })
     */
    private $productType;

    /**
     * @ORM\OneToMany(targetEntity="CartProduct", mappedBy="product")
     */
    private $addedToCarts;

    /**
     * Product constructor.
     */
    public function __construct()
    {
        $this->addedToCarts = new ArrayCollection();
    }


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string|null
     */
    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    /**
     * @param string|null $imageUrl
     */
    public function setImageUrl(?string $imageUrl): void
    {
        $this->imageUrl = $imageUrl;
    }

    /**
     * @return ProductType
     */
    public function getProductType(): ProductType
    {
        return $this->productType;
    }

    /**
     * @param ProductType $productType
     */
    public function setProductType(ProductType $productType): void
    {
        $this->productType = $productType;
    }

    public function addToCart(CartProduct $cartProduct): self
    {
        if (!$this->addedToCarts->contains($cartProduct)) {
            $this->addedToCarts[] = $cartProduct;
        }

//        /** @var CartProducts $addedToCart */
//        foreach ($this->addedToCarts as $addedToCart) {
//            if ($addedToCart->getId() === $this->getId()) {
//                $addedToCart->incrementProductCount();
//            }
//        }

        return $this;
    }

    public function removeFromCart(Cart $cart): self
    {
        if (!$this->addedToCarts->contains($cart)) {
            return $this;
        }

        /** @var CartProduct $addedToCart */
        foreach ($this->addedToCarts as $addedToCart) {
            if ($addedToCart->getProduct()->getId() === $this->getId() && $addedToCart->getProductCount() === 1) {
                $this->addedToCarts->removeElement($cart);
                $cart->removeProduct($this);

                return $this;
            }
            if ($addedToCart->getProduct()->getId() === $this->getId()) {
                $addedToCart->decrementProductCount();

                return $this;
            }
        }

        return $this;
    }
}
