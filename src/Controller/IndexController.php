<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;

class IndexController extends AbstractController
{
    /**
     * @Route("/api/v1/getPizzas", name="get_pizza_list")
     */
    public function index()
    {
      $pizzaList = $this->getDoctrine()->getRepository(Product::class)->findAll();
      return $this->json($pizzaList);
    }
}
