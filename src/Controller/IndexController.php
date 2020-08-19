<?php

namespace App\Controller;

use App\Entity\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;

class IndexController extends AbstractController
{
    /**
     * @Route("/getPizzas", name="get_pizza_list")
     */
    final public function getPizzas(): Response
    {
      $pizzaList = $this->getDoctrine()->getRepository(Product::class)->findByProductType(ProductType::PIZZA_TYPE);
      return $this->render('shop/pizza_list.html.twig', ['products' => $pizzaList]);
    }

    /**
     * @Route("/getToppings", name="get_topping_list")
     */
    final public function getToppings(): Response
    {
        $toppingList = $this->getDoctrine()->getRepository(Product::class)->findByProductType(ProductType::TOPPING_TYPE);
        return $this->render('shop/pizza_list.html.twig', ['products' => $toppingList]);
    }
}
