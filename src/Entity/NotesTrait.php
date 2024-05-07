<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

trait NotesTrait {
    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $notes = null;

    public function getNotes() : ?string {
        return $this->notes;
    }

    public function setNotes(?string $notes) : self {
        $this->notes = $notes;

        return $this;
    }
}
