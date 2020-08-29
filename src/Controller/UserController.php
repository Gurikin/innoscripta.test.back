<?php

namespace App\Controller;

use App\Entity\User;
use App\Model\OrderHistoryDtoCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private EntityManagerInterface $em;

    /**
     * UserController constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/user/order-history", name="user_order_history", methods={"GET"})
     */
    public function getOrderHistory(): Response
    {
        if (null === $this->getUser()) {
            return $this->redirectToRoute('index', [], Response::HTTP_UNAUTHORIZED);
        }

        /** @var User $user */
        $user = $this->em->getRepository(User::class)->findOneBy(['email' => $this->getUser()->getUsername()]);
        $customers = $user->getCustomers();

        $ordersHistoryCollection = new OrderHistoryDtoCollection($customers);

        return $this->render('user/order-history.html.twig', [
            'orders'      => $ordersHistoryCollection->getCollection(),
            'ordersRange' => $ordersHistoryCollection->getRangeOfOrdersHistory(),
            'totalPrice'  => $ordersHistoryCollection->getTotalPrice()
        ]);
    }
}
