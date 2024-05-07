<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\HoldingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Nines\MediaBundle\Entity\ImageContainerInterface;
use Nines\MediaBundle\Entity\ImageContainerTrait;
use Nines\UtilBundle\Entity\AbstractEntity;

#[ORM\Entity(repositoryClass: HoldingRepository::class)]
class Holding extends AbstractEntity implements ImageContainerInterface {
    use ImageContainerTrait {
        ImageContainerTrait::__construct as protected trait_constructor;
    }
    use DatedTrait;
    use NotesTrait;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    #[ORM\ManyToOne(targetEntity: Parish::class, inversedBy: 'holdings')]
    private ?Parish $parish = null;

    #[ORM\ManyToMany(targetEntity: Book::class, inversedBy: 'holdings')]
    private Collection $books;

    #[ORM\ManyToOne(targetEntity: Archive::class, inversedBy: 'holdings')]
    private ?Archive $archive = null;

    public function __construct() {
        parent::__construct();
        $this->trait_constructor();
        $this->books = new ArrayCollection();
    }

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
