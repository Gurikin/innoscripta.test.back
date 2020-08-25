<?php

namespace App\Controller;

use App\Entity\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    final public function index(): Response
    {
      $pizzaList = $this->getDoctrine()->getRepository(Product::class)->findByProductType(ProductType::PIZZA_TYPE);
      return $this->render('base.html.twig', ['products' => $pizzaList]);
    }

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
    final public function getToppings(): JsonResponse
    {
        $toppingList = $this->getDoctrine()->getRepository(Product::class)->findByProductType(ProductType::TOPPING_TYPE);
        return $this->json($toppingList, Response::HTTP_OK);
    }
}
