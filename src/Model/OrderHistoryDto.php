<?php


namespace App\Model;


use App\Entity\Order;
use DateTimeInterface;

class OrderHistoryDto
{
    private int $id;
    private DateTimeInterface $orderedAt;
    private float $orderPrice;

    /**
     * OrderHistoryDto constructor.
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->id = $order->getId();
        $this->orderedAt = $order->getCreatedAt();
        $this->orderPrice = $order->getCustomer()->getCart()->getTotalPrice();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getOrderedAt(): ?DateTimeInterface
    {
        return $this->orderedAt;
    }

    /**
     * @return float
     */
    public function getOrderPrice(): float
    {
        return $this->orderPrice;
    }
}