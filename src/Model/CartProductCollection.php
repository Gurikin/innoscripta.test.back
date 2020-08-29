<?php


namespace App\Model;


use App\Entity\CartProduct;
use Doctrine\Common\Collections\Collection;

final class CartProductCollection extends AbstractDtoCollection
{
    protected function convertCollection(Collection $sourceCartProductCollection)
    {
        /** @var CartProduct $cartProduct */
        foreach ($sourceCartProductCollection as $cartProduct) {
            $cartProductId = $cartProduct->getProduct()->getId();

            if (in_array($cartProductId, $this->collection->getKeys())) {
                $this->collection->get($cartProductId)->incrementProductCount();
                continue;
            }

            $this->collection->set($cartProductId, new CartProductDto($cartProduct));
        }
    }
}