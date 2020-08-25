<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\Order;
use App\Model\Type\OrderType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    private EntityManagerInterface $em;

    /**
     * OrderController constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    /**
     * @Route("/order", name="order", methods={"GET"})
     */
    public function index()
    {
        $orderForm = $this->createForm(OrderType::class);
        return $this->render('order/order-form.html.twig', [
            'orderForm' => $orderForm->createView(),
        ]);
    }

    /**
     * @Route("/order", name="save_order", methods={"POST"})
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function saveOrder(Request $request)
    {
        $cart = $this->em->getRepository(Cart::class)->find($request->getSession()->get('cartId'));
        // just setup a fresh $task object (remove the example data)
        $order = new Order();

        $orderForm = $this->createForm(OrderType::class, $order);

        $orderForm->handleRequest($request);
        if ($orderForm->isSubmitted() && $orderForm->isValid()) {
            /** @var Order $order */
            $order = $orderForm->getData();
            $order->setProductsCost($cart->getTotalPrice());

            $this->em->persist($order);
            $this->em->flush();

            $request->getSession()->invalidate();

            $totalPrice = $order->getProductsCost() + $order->getDeliveryCost();
            return $this->redirectToRoute('order_success', ['totalPrice' => $totalPrice]);
        }

        return $this->render('order/order-form.html.twig', [
            'orderForm' => $orderForm
        ]);
    }

    /**
     * @Route("/order-success", name="order_success", methods={"GET"})
     * @param Request $request
     * @return Response
     */
    public function orderSuccess(Request $request)
    {
        return $this->render('order/order-success.html.twig', ['totalPrice' => $request->get('totalPrice')]);
    }
}
