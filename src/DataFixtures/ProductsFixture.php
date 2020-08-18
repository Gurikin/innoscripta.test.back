<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductsFixture extends Fixture
{
    private const PRODUCTS_DATA = [
        [
            'name'        => 'NEW YORK HOT DOG',
            'productType' => 1,
            'price'       => 10,
            'description' => 'So hot right now. Tomato sauce, mozzarella, hot dog, caramelised onions, red onions and French\'s mustard drizzle.',
            'imageUrl'    => 'hero-new-york-hot-dog.png',
        ],
        [
            'name'        => 'EPIC MEAT FEAST',
            'productType' => 1,
            'price'       => 15,
            'description' => 'Triple cheese, shaved steak, paprika pulled chicken, pepperoni & ham.',
            'imageUrl'    => 'food-hero-epic-meatfeast.png',
        ],
        [
            'name'        => 'BBQ AMERICANO',
            'productType' => 1,
            'price'       => 12,
            'description' => 'Smoky BBQ sauce, chicken breast, bacon & sweetcorn with a BBQ drizzle.',
            'imageUrl'    => 'food-hero-new-bbq-am2.png',
        ],
        [
            'name'        => 'HOT \'N\' SPICY CHICKEN',
            'productType' => 1,
            'price'       => 11.5,
            'description' => 'Triple cheese blend, chicken breast, paprika pulled chicken, peppers, jalapenos and red onions with Hut House seasoning.',
            'imageUrl'    => 'hero_hotspicy_chicken.png',
        ],
        [
            'name'        => 'VEGAN PEPPERPHONI',
            'productType' => 1,
            'price'       => 12.5,
            'description' => 'Tomato sauce, Violife Vegan Cheese and Meat-Free Pepperphoni. Made from pea protein, just for Veganuary.',
            'imageUrl'    => 'hero-vegan-pepperphoni.png',
        ],
        [
            'name'        => 'BBQ JACK \'N\' CHEESE',
            'productType' => 1,
            'price'       => 14,
            'description' => 'Mozzarella, BBQ jackfruit, peppers, red onions, sweetcorn and a BBQ drizzle.',
            'imageUrl'    => 'hero-jackncheese2.png',
        ],
        [
            'name'        => 'EPIC VEGGIE',
            'productType' => 1,
            'price'       => 13.5,
            'description' => 'Triple cheese blend, flame roasted peppers & onions, garlic mushrooms, cherry tomatoes & spinach.',
            'imageUrl'    => 'food-hero-epic-veggie.png',
        ],
        [
            'name'        => 'HAM & GARLIC MUSHROOM FLATBREAD',
            'productType' => 1,
            'price'       => 9,
            'description' => 'Tomato sauce, mozzarella, spinach, ham, garlic & closed cup mushrooms, a ranch drizzle and rocket.',
            'imageUrl'    => 'hero_ham_garlic_faltbread.png',
        ],
        [
            'name'        => 'VEGGIE',
            'productType' => 1,
            'price'       => 8.5,
            'description' => 'Fresh spinach, sweetcorn, mixed peppers, red onions & mushrooms.',
            'imageUrl'    => 'food-hero-newveggie.png',
        ],
        [
            'name'        => 'EXTRA SAUCE',
            'productType' => 2,
            'price'       => 1.5,
            'description' => null,
            'imageUrl'    => null,
        ],
        [
            'name'        => 'EXTRA CHEESE',
            'productType' => 2,
            'price'       => 1.5,
            'description' => null,
            'imageUrl'    => null,
        ],
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::PRODUCTS_DATA as $productData) {
            $product = new Product();
            foreach ($productData as $productFieldName => $productFieldValue) {
                $method = $this->getSetter($productFieldName);
                $product->$method($productFieldValue);
            }
            $manager->persist($product);
        }

        $manager->flush();
    }

    /**
     * @param string $fieldName
     * @return string
     */
    private function getSetter(string $fieldName): string
    {
        return 'set' . ucfirst($fieldName);
    }
}
