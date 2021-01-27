<?php


namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

trait DatedTrait {

    /**
     * @var DateTime
     * @ORM\Column(type="date", nullable=true)
     */
    private $startDate;

    /**
     * @var DateTime
     * @ORM\Column(type="date", nullable=true)
     */
    private $endDate;

    /**
     * @return DateTime
     */
    public function getStartDate() : ?DateTime {
        return $this->startDate;
    }

    /**
     * @param DateTime $startDate
     */
    public function setStartDate(?DateTime $startDate) : void {
        $this->startDate = $startDate;
    }

    /**
     * @return DateTime
     */
    public function getEndDate() : ?DateTime {
        return $this->endDate;
    }

    /**
     * @param DateTime $endDate
     */
    public function setEndDate(?DateTime $endDate) : void {
        $this->endDate = $endDate;
    }

}
