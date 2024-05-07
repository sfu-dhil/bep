<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\TransactionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Nines\UtilBundle\Entity\AbstractEntity;

#[ORM\Table(name: 'transact')]
#[ORM\Index(name: 'transaction_ft', columns: ['transcription', 'modern_transcription', 'notes'], flags: ['fulltext'])]
#[ORM\Entity(repositoryClass: TransactionRepository::class)]
class Transaction extends AbstractEntity {
    use DatedTrait;
    use NotesTrait;

    /**
     * Price of the transaction in pennies.
     *
     * £2. 3s. 6d. (two pounds, three shillings and six pence) is recorded as
     *
     * 2 * 240 + 3 * 12 + 6 = 522
     */
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $value = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $shipping = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $copies = null;

    #[ORM\Column(type: 'string', length: 160, nullable: true)]
    private ?string $location = null;

    #[ORM\Column(type: 'string', length: 24, nullable: true)]
    private ?string $page = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $transcription = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $modernTranscription = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $publicNotes = null;

    /**
     * @var Collection<int,Book>
     */
    #[ORM\ManyToMany(targetEntity: Book::class, inversedBy: 'transactions')]
    private Collection $books;

    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    #[ORM\ManyToOne(targetEntity: Parish::class, inversedBy: 'transactions')]
    private ?Parish $parish = null;

    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    #[ORM\ManyToOne(targetEntity: ManuscriptSource::class, inversedBy: 'transactions')]
    private ?ManuscriptSource $manuscriptSource = null;

    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    #[ORM\ManyToOne(targetEntity: PrintSource::class, inversedBy: 'transactions')]
    private ?PrintSource $printSource = null;

    /**
     * @var Collection<int,TransactionCategory>
     */
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    #[ORM\ManyToMany(targetEntity: TransactionCategory::class, inversedBy: 'transactions')]
    private Collection $transactionCategories;

    #[ORM\ManyToOne(targetEntity: Injunction::class, inversedBy: 'transactions')]
    private ?Injunction $injunction = null;

    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    #[ORM\ManyToOne(targetEntity: Monarch::class, inversedBy: 'transactions')]
    private ?Monarch $monarch = null;

    public function __construct() {
        parent::__construct();
        $this->copies = 1;
        $this->books = new ArrayCollection();
        $this->transactionCategories = new ArrayCollection();
    }

    public function __toString() : string {
        return sprintf('%05d', $this->id);
    }

    /**
     * @return array|float|string
     */
    public function getValue(bool $format = false, bool $list = false) {
        if ($format) {
            $l = floor($this->value / 240);
            $s = floor(($this->value - $l * 240) / 12);
            $d = $this->value - $s * 12 - $l * 240;
            if ($list) {
                return [$l, $s, $d];
            }

            return "£{$l}. {$s}s. {$d}d";
        }

        return $this->value;
    }

    public function setValue(?int $value) : self {
        $this->value = $value;

        return $this;
    }

    public function setLsd(int $l, int $s, int $d) : self {
        $this->value = 240 * $l + 12 * $s + $d;

        return $this;
    }

    public function getModernTranscription() : ?string {
        return $this->modernTranscription;
    }

    public function setModernTranscription(?string $modernTranscription) : self {
        $this->modernTranscription = $modernTranscription;

        return $this;
    }

    public function getParish() : ?Parish {
        return $this->parish;
    }

    public function setParish(?Parish $parish) : self {
        $this->parish = $parish;

        return $this;
    }

    public function getCopies() : ?int {
        return $this->copies;
    }

    public function setCopies(?int $copies) : self {
        $this->copies = $copies;

        return $this;
    }

    public function getTranscription() : ?string {
        return $this->transcription;
    }

    public function setTranscription(?string $transcription) : self {
        $this->transcription = $transcription;

        return $this;
    }

    public function getManuscriptSource() : ?ManuscriptSource {
        return $this->manuscriptSource;
    }

    public function setManuscriptSource(?ManuscriptSource $manuscriptSource) : self {
        $this->manuscriptSource = $manuscriptSource;

        return $this;
    }

    public function getInjunction() : ?Injunction {
        return $this->injunction;
    }

    public function setInjunction(?Injunction $injunction) : self {
        $this->injunction = $injunction;

        return $this;
    }

    /**
     * @return array|float|string
     */
    public function getShippingValue(bool $format = false, bool $list = false) {
        if ($format) {
            $l = floor($this->shipping / 240);
            $s = floor(($this->shipping - $l * 240) / 12);
            $d = $this->shipping - $s * 12 - $l * 240;
            if ($list) {
                return [$l, $s, $d];
            }

            return "£{$l}. {$s}s. {$d}d";
        }

        return $this->shipping;
    }

    public function setShippingValue(?int $shipping) : self {
        $this->shipping = $shipping;

        return $this;
    }

    public function setShippingLsd(int $l, int $s, int $d) : self {
        $this->shipping = 240 * $l + 12 * $s + $d;

        return $this;
    }

    public function getPage() : ?string {
        return $this->page;
    }

    public function setPage(?string $page) : self {
        $this->page = $page;

        return $this;
    }

    public function getLocation() : ?string {
        return $this->location;
    }

    public function setLocation(?string $location) : self {
        $this->location = $location;

        return $this;
    }

    public function getShipping() : ?int {
        return $this->shipping;
    }

    public function setShipping(?int $shipping) : self {
        $this->shipping = $shipping;

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

    /**
     * @return Collection|TransactionCategory[]
     */
    public function getTransactionCategories() : Collection {
        return $this->transactionCategories;
    }

    public function addTransactionCategory(TransactionCategory $transactionCategory) : self {
        if ( ! $this->transactionCategories->contains($transactionCategory)) {
            $this->transactionCategories[] = $transactionCategory;
        }

        return $this;
    }

    public function removeTransactionCategory(TransactionCategory $transactionCategory) : self {
        $this->transactionCategories->removeElement($transactionCategory);

        return $this;
    }

    public function getMonarch() : ?Monarch {
        return $this->monarch;
    }

    public function setMonarch(?Monarch $monarch) : self {
        $this->monarch = $monarch;

        return $this;
    }

    public function getPublicNotes() : ?string {
        return $this->publicNotes;
    }

    public function setPublicNotes(?string $publicNotes) : void {
        $this->publicNotes = $publicNotes;
    }

    public function getPrintSource() : ?PrintSource {
        return $this->printSource;
    }

    public function setPrintSource(?PrintSource $printSource) : self {
        $this->printSource = $printSource;

        return $this;
    }
}
