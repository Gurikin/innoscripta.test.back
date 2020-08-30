<?php


namespace App\Model;


use App\Entity\Customer;
use App\Helper\DateRange;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Exception;

class OrderHistoryDtoCollection
{
    private float $totalOrdersPrice = 0.0;
    private DateRange $rangeOfOrdersHistory;

    protected ArrayCollection $collection;

    /**
     * CartProductCollection constructor.
     * @param Collection $sourceCollection
     * @throws Exception
     */
    public function __construct(Collection $sourceCollection)
    {
        $this->rangeOfOrdersHistory = new DateRange();
        $this->collection = new ArrayCollection();
        $this->convertCollection($sourceCollection);
    }

    public function getCollection(): array
    {
        $resultCollection = $this->collection->getValues();
        ksort($resultCollection);
        return $resultCollection;
    }


    protected function convertCollection(Collection $sourceCollection)
    {
        /** @var Customer $customer */
        foreach ($sourceCollection as $customer) {
            $order = $customer->getPizzaOrder();
            $orderHistoryDto = new OrderHistoryDto($order);

            $this->collection->set($order->getId(), $orderHistoryDto);

            $this->totalOrdersPrice += $customer->getCart()->getTotalPrice();
            $this->rangeOfOrdersHistory->setLimits($order->getCreatedAt());
        }
    }

    /**
     * @return float
     */
    public function getTotalOrdersPrice(): float
    {
        return $this->totalOrdersPrice;
    }

    /**
     * @return DateRange
     */
    public function getRangeOfOrdersHistory(): DateRange
    {
        return $this->rangeOfOrdersHistory;
    }
}
