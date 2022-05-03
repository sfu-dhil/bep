<?php

declare(strict_types=1);

/*
 * (c) 2021 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Entity;

use App\Repository\TransactionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Nines\UtilBundle\Entity\AbstractEntity;

/**
 * @ORM\Entity(repositoryClass=TransactionRepository::class)
 * @ORM\Table(name="transact", indexes={
 *     @ORM\Index(name="transaction_ft", columns={"transcription", "modern_transcription", "notes"}, flags={"fulltext"})
 * })
 */
class Transaction extends AbstractEntity {
    use DatedTrait;
    use NotesTrait;

    /**
     * Price of the transaction in pennies.
     *
     * £2. 3s. 6d. (two pounds, three shillings and six pence) is recorded as
     *
     * 2 * 240 + 3 * 12 + 6 = 522
     *
     * @var int
     * @ORM\Column(type="integer", nullable=true)
     */
    private $value;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=true)
     */
    private $shipping;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=true)
     */
    private $copies;

    /**
     * @var string
     * @ORM\Column(type="string", length=160, nullable=true)
     */
    private $location;

    /**
     * @var string
     * @ORM\Column(type="string", length=24, nullable=true)
     */
    private $page;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $transcription;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $modernTranscription;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $publicNotes;

    /**
     * @var Book[]|Collection
     * @ORM\ManyToMany(targetEntity="App\Entity\Book", inversedBy="transactions")
     */
    private $books;

    /**
     * @var Parish
     * @ORM\ManyToOne(targetEntity="App\Entity\Parish", inversedBy="transactions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $parish;

    /**
     * @var Source
     * @ORM\ManyToOne(targetEntity="Source", inversedBy="transactions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $source;

    /**
     * @var Collection|TransactionCategory[]
     * @ORM\ManyToMany(targetEntity="App\Entity\TransactionCategory", inversedBy="transactions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $transactionCategories;

    /**
     * @var Injunction
     * @ORM\ManyToOne(targetEntity="Injunction", inversedBy="transactions")
     */
    private $injunction;

    /**
     * @var Monarch
     * @ORM\ManyToOne(targetEntity="Monarch", inversedBy="transactions")
     * @ORM\JoinColumn(nullable=true)
     */
    private $monarch;

    public function __construct() {
        parent::__construct();
        $this->copies = 1;
        $this->books = new ArrayCollection();
        $this->transactionCategories = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
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

    public function getSource() : ?Source {
        return $this->source;
    }

    public function setSource(?Source $source) : self {
        $this->source = $source;

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

    /**
     * @return string
     */
    public function getPublicNotes() : ?string {
        return $this->publicNotes;
    }

    public function setPublicNotes(?string $publicNotes) : void {
        $this->publicNotes = $publicNotes;
    }
}
