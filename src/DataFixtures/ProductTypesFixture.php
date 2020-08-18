<?php

namespace App\DataFixtures;

use App\Entity\ProductTypes;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductTypesFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $productType = new ProductTypes();
        $productType->setName('pizza');
        $manager->persist($productType);
        $productType = new ProductTypes();
        $productType->setName('topping');
        $manager->persist($productType);

        $manager->flush();
    }
}
