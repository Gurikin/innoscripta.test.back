<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\Customer;
use App\Entity\Order;
use App\Entity\User;
use App\Form\OrderFormType;
use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;
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
     * @Route("/order", name="order", methods={"GET"}, schemes={"https"})
     */
    public function index()
    {
        $orderForm = $this->createForm(OrderFormType::class);
        return $this->render('order/order-form.html.twig', [
            'orderForm' => $orderForm->createView(),
        ]);
    }

    /**
     * @Route("/order", name="save_order", methods={"POST"}, schemes={"https"})
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function saveOrder(Request $request)
    {
        $cart = $this->em->getRepository(Cart::class)->find($request->getSession()->get('cartId'));
        // just setup a fresh $task object (remove the example data)
        $order = new Order();

        $orderForm = $this->createForm(OrderFormType::class, $order);

        $orderForm->handleRequest($request);
        if (!$orderForm->isSubmitted() || !$orderForm->isValid()) {
            return $this->render('order/order-form.html.twig', [
                'orderForm' => $orderForm->createView()
            ]);
        }

        /** @var Order $order */
        $order = $orderForm->getData();

        try {
            $this->em->beginTransaction();
            $order->setProductsCost($cart->getTotalPrice());

            $customer = $this->em->getRepository(Customer::class)
                ->findOneBy(['token' => $request->getSession()->get('customerToken')]);

            $order->setCustomer($customer);

            if (null !== $this->getUser()) {
                $user = $this->em->getRepository(User::class)->findOneBy(['email' => $this->getUser()->getUsername()]);
                $user->addCustomer($customer);
                $this->em->persist($user);
            }

            $this->em->persist($order);

            $this->em->flush();
            $this->em->commit();
        } catch (RuntimeException $e) {
            $this->em->rollback();
        }

        $request->getSession()->remove('customerToken');
        $request->getSession()->remove('cartId');

        $totalPrice = $order->getProductsCost() + $order->getDeliveryCost();
        return $this->redirectToRoute('order_success', ['totalPrice' => $totalPrice]);
    }

    /**
     * @Route("/order-success", name="order_success", methods={"GET"}, schemes={"https"})
     * @param Request $request
     * @return Response
     */
    public
    function orderSuccess(Request $request)
    {
        return $this->render('order/order-success.html.twig', ['totalPrice' => $request->get('totalPrice')]);
    }
}
