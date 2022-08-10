<?php

declare(strict_types=1);

/*
 * (c) 2022 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

trait DatedTrait {
    /**
     * @var string
     * @ORM\Column(type="string", length=10, nullable=true)
     * @Assert\Date(message="{{ value }} is not a valid value. It must be formatted as yyyy-mm-dd and be a valid date.")
     */
    private $startDate;

    /**
     * @var string
     * @ORM\Column(type="string", length=10, nullable=true)
     * @Assert\Date(message="{{ value }} is not a valid value. It must be formatted as yyyy-mm-dd and be a valid date.")
     */
    private $endDate;

    /**
     * @var string
     * @ORM\Column(type="string", length=60, nullable=true)
     */
    private $writtenDate;

    /**
     * @return string
     */
    public function getStartDate() : ?string {
        return $this->startDate;
    }

    /**
     * @param string $startDate
     */
    public function setStartDate(?string $startDate) : void {
        $this->startDate = $startDate;
    }

    /**
     * @return string
     */
    public function getEndDate() : ?string {
        return $this->endDate;
    }

    /**
     * @param string $endDate
     */
    public function setEndDate(?string $endDate) : void {
        $this->endDate = $endDate;
    }

    /**
     * @return string
     */
    public function getWrittenDate() : ?string {
        return $this->writtenDate;
    }

    /**
     * @param string $writtenDate
     */
    public function setWrittenDate(?string $writtenDate) : void {
        $this->writtenDate = $writtenDate;
    }
}
