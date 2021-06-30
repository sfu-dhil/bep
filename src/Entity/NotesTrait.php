<?php

declare(strict_types=1);

/*
 * (c) 2021 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Entity;

trait NotesTrait {
    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $notes;

    public function getNotes() : ?string {
        return $this->notes;
    }

    /**
     * @param ?string $notes
     *
     * @return $this
     */
    public function setNotes(?string $notes) : self {
        $this->notes = $notes;

        return $this;
    }
}
