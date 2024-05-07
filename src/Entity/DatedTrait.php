<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

trait DatedTrait {
    #[Assert\Date(message: '{{ value }} is not a valid value. It must be formatted as yyyy-mm-dd and be a valid date.')]
    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $startDate = null;

    #[Assert\Date(message: '{{ value }} is not a valid value. It must be formatted as yyyy-mm-dd and be a valid date.')]
    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $endDate = null;

    #[ORM\Column(type: 'string', length: 60, nullable: true)]
    private ?string $writtenDate = null;

    public function getStartDate() : ?string {
        return $this->startDate;
    }

    public function setStartDate(?string $startDate) : void {
        $this->startDate = $startDate;
    }

    public function getEndDate() : ?string {
        return $this->endDate;
    }

    public function setEndDate(?string $endDate) : void {
        $this->endDate = $endDate;
    }

    public function getWrittenDate() : ?string {
        return $this->writtenDate;
    }

    public function setWrittenDate(?string $writtenDate) : void {
        $this->writtenDate = $writtenDate;
    }
}
