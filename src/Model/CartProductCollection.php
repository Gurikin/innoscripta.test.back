<?php


namespace App\Model;


use App\Entity\Cart;
use App\Entity\CartProduct;
use App\Entity\Product;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;

final class CartProductCollection
{
    private ArrayCollection $cartProductCollection;

    /**
     * CartProductCollection constructor.
     * @param PersistentCollection $sourceCartProductCollection
     */
    public function __construct(PersistentCollection $sourceCartProductCollection)
    {
        $this->cartProductCollection = new ArrayCollection();
        $this->convertCartProductCollection($sourceCartProductCollection);
    }

    public function getCartProductCollection(): ArrayCollection
    {
        return $this->cartProductCollection;
    }

    private function convertCartProductCollection(PersistentCollection $sourceCartProductCollection)
    {
        /** @var CartProduct $cartProduct */
        foreach ($sourceCartProductCollection as $cartProduct) {
            $cartProductId = $cartProduct->getProduct()->getId();

            if (in_array($cartProductId, $this->cartProductCollection->getKeys())) {
                $this->cartProductCollection->get($cartProductId)->incrementProductCount();
                continue;
            }

            $this->cartProductCollection->set($cartProductId, new CartProductDto($cartProduct));
        }
    }
}