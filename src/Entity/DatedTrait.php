<?php

declare(strict_types=1);

/*
 * (c) 2020 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Entity;

use DateTime;
use DateTimeImmutable;
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
    public function getStartDate() : ?DateTimeImmutable {
        return $this->startDate;
    }

    /**
     * @param DateTime $startDate
     */
    public function setStartDate(?DateTimeImmutable $startDate) : void {
        $this->startDate = $startDate;
    }

    /**
     * @return DateTime
     */
    public function getEndDate() : ?DateTimeImmutable {
        return $this->endDate;
    }

    /**
     * @param DateTime $endDate
     */
    public function setEndDate(?DateTimeImmutable $endDate) : void {
        $this->endDate = $endDate;
    }
}
