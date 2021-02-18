<?php

declare(strict_types=1);

/*
 * (c) 2020 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Nines\MediaBundle\Entity\LinkableInterface;
use Nines\MediaBundle\Entity\LinkableTrait;
use Nines\UtilBundle\Entity\AbstractEntity;

/**
 * @ORM\Entity(repositoryClass=BookRepository::class)
 */
class Book extends AbstractEntity implements LinkableInterface {
    use LinkableTrait {
        LinkableTrait::__construct as linkable_construct;
    }

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $title;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $uniformTitle;

    /**
     * @var string
     * @ORM\Column(type="array")
     */
    private $variantTitles;

    /**
     * @var string
     * @ORM\Column(type="string", length=160, nullable=true)
     */
    private $author;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $publisher;

    /**
     * @var string
     * @ORM\Column(type="string", length=12, nullable=true)
     */
    private $date;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @var Format
     * @ORM\ManyToOne(targetEntity="Format", inversedBy="books")
     */
    private $format;

    /**
     * @var Collection|Transaction[]
     * @ORM\OneToMany(targetEntity="App\Entity\Transaction", mappedBy="book")
     */
    private $transactions;

    /**
     * @var Collection|Inventory[]
     * @ORM\OneToMany(targetEntity="App\Entity\Inventory", mappedBy="book")
     */
    private $inventories;

    /**
     * @var Collection|Holding[]
     * @ORM\OneToMany(targetEntity="App\Entity\Holding", mappedBy="book")
     */
    private $holdings;

    public function __construct() {
        parent::__construct();
        $this->linkable_construct();
        $this->transactions = new ArrayCollection();
        $this->variantTitles = [];
        $this->inventories = new ArrayCollection();
        $this->holdings = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function __toString() : string {
        if ($this->uniformTitle) {
            return $this->uniformTitle;
        }
        if ($this->title) {
            return $this->title;
        }
        if ($this->description) {
            return $this->description;
        }

        return 'No description provided';
    }

    public function getTitle() : ?string {
        return $this->title;
    }

    public function setTitle(?string $title) : self {
        $this->title = $title;

        return $this;
    }

    public function getDate() : ?string {
        return $this->date;
    }

    public function setDate(?string $date) : self {
        $this->date = $date;

        return $this;
    }

    public function getDescription() : ?string {
        return $this->description;
    }

    public function setDescription(?string $description) : self {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getTransactions() : Collection {
        return $this->transactions;
    }

    public function addTransaction(Transaction $transaction) : self {
        if ( ! $this->transactions->contains($transaction)) {
            $this->transactions[] = $transaction;
            $transaction->setBook($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction) : self {
        if ($this->transactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getBook() === $this) {
                $transaction->setBook(null);
            }
        }

        return $this;
    }

    public function getFormat() : ?Format {
        return $this->format;
    }

    public function setFormat(?Format $format) : self {
        $this->format = $format;

        return $this;
    }

    public function getVariantTitles() : ?array {
        return $this->variantTitles;
    }

    public function addVariant(string $variant) : self {
        if ( ! in_array($variant, $this->variantTitles, true)) {
            $this->variantTitles[] = $variant;
        }

        return $this;
    }

    public function setVariantTitles(array $variantTitles) : self {
        $this->variantTitles = $variantTitles;

        return $this;
    }

    public function getUniformTitle() : ?string {
        return $this->uniformTitle;
    }

    public function setUniformTitle(?string $uniformTitle) : self {
        $this->uniformTitle = $uniformTitle;

        return $this;
    }

    public function getAuthor() : ?string {
        return $this->author;
    }

    public function setAuthor(?string $author) : self {
        $this->author = $author;

        return $this;
    }

    public function getPublisher() : ?string {
        return $this->publisher;
    }

    public function setPublisher(?string $publisher) : self {
        $this->publisher = $publisher;

        return $this;
    }

    /**
     * @return Collection|Inventory[]
     */
    public function getInventories() : Collection {
        return $this->inventories;
    }

    public function addInventory(Inventory $inventory) : self {
        if ( ! $this->inventories->contains($inventory)) {
            $this->inventories[] = $inventory;
            $inventory->setBook($this);
        }

        return $this;
    }

    public function removeInventory(Inventory $inventory) : self {
        if ($this->inventories->removeElement($inventory)) {
            // set the owning side to null (unless already changed)
            if ($inventory->getBook() === $this) {
                $inventory->setBook(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Holding[]
     */
    public function getHoldings() : Collection {
        return $this->holdings;
    }

    public function addHolding(Holding $holding) : self {
        if ( ! $this->holdings->contains($holding)) {
            $this->holdings[] = $holding;
            $holding->setBook($this);
        }

        return $this;
    }

    public function removeHolding(Holding $holding) : self {
        if ($this->holdings->removeElement($holding)) {
            // set the owning side to null (unless already changed)
            if ($holding->getBook() === $this) {
                $holding->setBook(null);
            }
        }

        return $this;
    }
}
