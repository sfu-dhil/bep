<?php


namespace App\Entity;


trait NotesTrait {
    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $notes;

    /**
     * @return string|null
     */
    public function getNotes() : ?string {
        return $this->notes;
    }

    /**
     * @param string|null $notes
     *
     * @return $this
     */
    public function setNotes(?string $notes) : self {
        $this->notes = $notes;

        return $this;
    }

}
