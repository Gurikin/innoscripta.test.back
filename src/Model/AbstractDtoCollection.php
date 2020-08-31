<?php


namespace App\Model;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

abstract class AbstractDtoCollection
{
    protected ArrayCollection $collection;

    /**
     * CartProductCollection constructor.
     * @param Collection $sourceCollection
     */
    public function __construct(Collection $sourceCollection)
    {
        $this->collection = new ArrayCollection();
        $this->convertCollection($sourceCollection);
    }

    public function getCollection(): array
    {
        $resultCollection = $this->collection->getValues();
        ksort($resultCollection);
        return $resultCollection;
    }

    abstract protected function convertCollection(Collection $sourceCollection);
}