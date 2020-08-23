<?php

namespace App\EventSubscriber;

use App\Entity\Cart;
use App\Entity\Customer;
use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class CustomerSubscriber implements EventSubscriberInterface
{
    private EntityManagerInterface $em;

    /**
     * CustomerSubscriber constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();

        if (!$token = $request->getSession()->get('customerToken')) {
            $customer = new Customer();
            $token = sha1($request->getClientIp() . $request->getSession()->getName());
            $customer->setToken($token);

            $this->em->persist($customer);
            $this->em->flush();

            $request->getSession()->set('customerToken', $token);
            $request->getSession()->set('cartId', $customer->getCart()->getId());

            return;
        }

        /** @var Customer $customer */
        $customer = $this->em->getRepository(Customer::class)->findOneBy(['token' => $token]);
        if ($customer->getCart() === null) {
            throw new RuntimeException('You are customer but cart was not created for you. Something wrong with your session.');
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.request' => 'onKernelRequest',
        ];
    }
}
