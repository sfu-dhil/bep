<?php

declare(strict_types=1);

/*
 * (c) 2021 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Entity;

use App\Repository\HoldingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Nines\MediaBundle\Entity\ImageContainerInterface;
use Nines\MediaBundle\Entity\ImageContainerTrait;
use Nines\UtilBundle\Entity\AbstractEntity;

/**
 * @ORM\Entity(repositoryClass=HoldingRepository::class)
 */
class Holding extends AbstractEntity implements ImageContainerInterface {
    use ImageContainerTrait {
        ImageContainerTrait::__construct as protected trait_constructor;
    }
    use DatedTrait;
    use NotesTrait;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @var Parish
     * @ORM\ManyToOne(targetEntity="App\Entity\Parish", inversedBy="holdings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $parish;

    /**
     * @var Collection
     * @ORM\ManyToMany(targetEntity="App\Entity\Book", inversedBy="holdings")
     */
    private $books;

    /**
     * @var Archive
     * @ORM\ManyToOne(targetEntity="App\Entity\Archive", inversedBy="holdings")
     */
    private $archive;

    public function __construct() {
        parent::__construct();
        $this->trait_constructor();
        $this->books = new ArrayCollection();
    }

    /**
     * {@inheritDoc}
     */
    public function __toString() : string {
        return implode(', ', $this->books->toArray()) . ' ' . $this->parish;
    }

    public function getDescription() : ?string {
        return $this->description;
    }

    public function setDescription(string $description) : self {
        $this->description = $description;

        return $this;
    }

    public function getParish() : ?Parish {
        return $this->parish;
    }

    public function setParish(?Parish $parish) : self {
        $this->parish = $parish;

        return $this;
    }

    /**
     * @return Book[]|Collection
     */
    public function getBooks() : Collection {
        return $this->books;
    }

    public function addBook(Book $book) : self {
        if ( ! $this->books->contains($book)) {
            $this->books[] = $book;
        }

        return $this;
    }

    public function removeBook(Book $book) : self {
        $this->books->removeElement($book);

        return $this;
    }

    public function getArchive() : ?Archive {
        return $this->archive;
    }

    public function setArchive(?Archive $archive) : self {
        $this->archive = $archive;

        return $this;
    }
}
