<?php


namespace App\Helper;


use DateTime;
use DateTimeInterface;
use Exception;

class DateRange
{
    private DateTimeInterface $from;
    private DateTimeInterface $to;

    /**
     * DateRange constructor.
     * @param DateTimeInterface $from
     * @param DateTimeInterface $to
     * @throws Exception
     */
    public function __construct(DateTimeInterface $from = null, DateTimeInterface $to = null)
    {
        $this->from = $from ?? new DateTime('now');
        $this->to = $to ?? new DateTime('1970');
    }

    /**
     * @return DateTimeInterface
     */
    public function getFrom(): DateTimeInterface
    {
        return $this->from;
    }

    /**
     * @return DateTimeInterface
     */
    public function getTo(): DateTimeInterface
    {
        return $this->to;
    }

    public function setLimits(DateTimeInterface $date)
    {
        $this->from = $date < $this->from ? $date : $this->from;
        $this->to = $date > $this->to ? $date : $this->to;
    }
}
