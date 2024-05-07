<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\InventoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Nines\MediaBundle\Entity\ImageContainerInterface;
use Nines\MediaBundle\Entity\ImageContainerTrait;
use Nines\UtilBundle\Entity\AbstractEntity;

#[ORM\Table]
#[ORM\Index(name: 'inventory_ft', columns: ['transcription', 'modifications', 'description', 'notes'], flags: ['fulltext'])]
#[ORM\Entity(repositoryClass: InventoryRepository::class)]
class Inventory extends AbstractEntity implements ImageContainerInterface {
    use DatedTrait;
    use NotesTrait;
    use ImageContainerTrait {
        ImageContainerTrait::__construct as protected trait_constructor;
    }

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $pageNumber = null;

    #[ORM\Column(type: 'text')]
    private ?string $transcription = null;

    #[ORM\Column(type: 'text')]
    private ?string $modifications = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    #[ORM\ManyToOne(targetEntity: ManuscriptSource::class, inversedBy: 'inventories')]
    private ?ManuscriptSource $manuscriptSource = null;

    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    #[ORM\ManyToOne(targetEntity: PrintSource::class, inversedBy: 'inventories')]
    private ?PrintSource $printSource = null;

    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    #[ORM\ManyToOne(targetEntity: Parish::class, inversedBy: 'inventories')]
    private ?Parish $parish = null;

    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    #[ORM\ManyToOne(targetEntity: Monarch::class, inversedBy: 'inventories')]
    private ?Monarch $monarch = null;

    #[ORM\ManyToOne(targetEntity: Injunction::class, inversedBy: 'inventories')]
    private ?Injunction $injunction = null;

    #[ORM\ManyToMany(targetEntity: Book::class, inversedBy: 'inventories')]
    private Collection $books;

    public function __construct() {
        parent::__construct();
        $this->trait_constructor();
        $this->books = new ArrayCollection();
    }

    public function __toString() : string {
        return mb_substr(strip_tags($this->transcription), 0, 50);
    }

    public function getTranscription() : ?string {
        return $this->transcription;
    }

    public function setTranscription(string $transcription) : self {
        $this->transcription = $transcription;

        return $this;
    }

    public function getModifications() : ?string {
        return $this->modifications;
    }

    public function setModifications(string $modifications) : self {
        $this->modifications = $modifications;

        return $this;
    }

    public function getDescription() : ?string {
        return $this->description;
    }

    public function setDescription(?string $description) : self {
        $this->description = $description;

        return $this;
    }

    public function getManuscriptSource() : ?ManuscriptSource {
        return $this->manuscriptSource;
    }

    public function setManuscriptSource(?ManuscriptSource $manuscriptSource) : self {
        $this->manuscriptSource = $manuscriptSource;

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

    public function getMonarch() : ?Monarch {
        return $this->monarch;
    }

    public function setMonarch(?Monarch $monarch) : self {
        $this->monarch = $monarch;

        return $this;
    }

    public function getPageNumber() : ?string {
        return $this->pageNumber;
    }

    public function setPageNumber(?string $pageNumber) : self {
        $this->pageNumber = $pageNumber;

        return $this;
    }

    public function getPrintSource() : ?PrintSource {
        return $this->printSource;
    }

    public function setPrintSource(?PrintSource $printSource) : self {
        $this->printSource = $printSource;

        return $this;
    }

    public function getInjunction() : ?Injunction {
        return $this->injunction;
    }

    public function setInjunction(?Injunction $injunction) : self {
        $this->injunction = $injunction;

        return $this;
    }
}
