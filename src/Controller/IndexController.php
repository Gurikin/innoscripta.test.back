<?php

namespace App\Controller;

use App\Entity\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;

class IndexController extends AbstractController
{
    /**
     * @Route("/api/v1/getPizzas", name="get_pizza_list")
     */
    public function getPizzas()
    {
      $pizzaList = $this->getDoctrine()->getRepository(Product::class)->findBy(['productType' => ProductType::PIZZA_TYPE]);
      return $this->json($pizzaList);
    }

    /**
     * @Route("/api/v1/getToppings", name="get_topping_list")
     */
    public function getToppings()
    {
        $toppingList = $this->getDoctrine()->getRepository(Product::class)->findBy(['productType' => ProductType::TOPPING_TYPE]);
        return $this->json($toppingList);
    }
}
