<?php


namespace App\Model;


use App\Entity\Customer;
use App\Helper\DateRange;
use Doctrine\Common\Collections\Collection;

class OrderHistoryDtoCollection extends AbstractDtoCollection
{
    private float $totalPrice = 0.0;
    private DateRange $rangeOfOrdersHistory;

    public function __construct(Collection $sourceCollection)
    {
        $this->rangeOfOrdersHistory = new DateRange();
        parent::__construct($sourceCollection);
    }


    protected function convertCollection(Collection $sourceCollection)
    {
        /** @var Customer $customer */
        foreach ($sourceCollection as $customer) {
            $order = $customer->getPizzaOrder();
            $orderHistoryDto = new OrderHistoryDto($order);

            $this->collection->set($order->getId(), $orderHistoryDto);

            $this->totalPrice += $customer->getCart()->getTotalPrice();
            $this->rangeOfOrdersHistory->setLimits($order->getCreatedAt());
        }
    }

    /**
     * @return float
     */
    public function getTotalPrice(): float
    {
        return $this->totalPrice;
    }

    /**
     * @return DateRange
     */
    public function getRangeOfOrdersHistory(): DateRange
    {
        return $this->rangeOfOrdersHistory;
    }
}
