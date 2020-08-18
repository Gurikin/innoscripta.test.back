<?php

namespace App\DataFixtures;

use App\Entity\ProductType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class ProductTypeFixture extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager)
    {
        $productType = new ProductType();
        $productType->setName('pizza');
        $this->addReference('pizza_type', $productType);
        $manager->persist($productType);
        $productType = new ProductType();
        $productType->setName('topping');
        $this->addReference('topping_type', $productType);
        $manager->persist($productType);

        $manager->flush();
    }

    /**
     * @inheritDoc
     */
    public static function getGroups(): array
    {
        return [self::class];
    }
}
