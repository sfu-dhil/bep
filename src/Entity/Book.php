<?php

declare(strict_types=1);

/*
 * (c) 2021 Michael Joyce <mjoyce@sfu.ca>
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
 * @ORM\Table(indexes={
 *     @ORM\Index(name="book_ft", columns={"title", "uniform_title", "variant_titles", "description", "author", "imprint", "variant_imprint", "notes"}, flags={"fulltext"})
 * })
 */
class Book extends AbstractEntity implements LinkableInterface {
    use LinkableTrait {
        LinkableTrait::__construct as linkable_construct;
    }
    use NotesTrait;

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
     * @var string[]
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
    private $imprint;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $variantImprint;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $estc;

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
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $physicalDescription;

    /**
     * @var Format
     * @ORM\ManyToOne(targetEntity="Format", inversedBy="books")
     */
    private $format;

    /**
     * @var Monarch
     * @ORM\ManyToOne(targetEntity="Monarch", inversedBy="books")
     * @ORM\JoinColumn(nullable=true)
     */
    private $monarch;

    /**
     * @var Collection|Transaction[]
     * @ORM\ManyToMany(targetEntity="Transaction", mappedBy="books")
     */
    private $transactions;

    /**
     * @var Collection|Inventory[]
     * @ORM\ManyToMany(targetEntity="Inventory", mappedBy="books")
     */
    private $inventories;

    /**
     * @var Collection|Holding[]
     * @ORM\ManyToMany(targetEntity="Holding", mappedBy="books")
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
            $transaction->addBook($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction) : self {
        if ($this->transactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getBooks()->contains($this)) {
                $transaction->removeBook($this);
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

    public function getImprint() : ?string {
        return $this->imprint;
    }

    public function setImprint(?string $imprint) : self {
        $this->imprint = $imprint;

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
            $inventory->addBook($this);
        }

        return $this;
    }

    public function removeInventory(Inventory $inventory) : self {
        if ($this->inventories->removeElement($inventory)) {
            // set the owning side to null (unless already changed)
            if ($inventory->getBooks()->contains($this)) {
                $inventory->removeBook($this);
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
            $holding->addBook($this);
        }

        return $this;
    }

    public function removeHolding(Holding $holding) : self {
        if ($this->holdings->removeElement($holding)) {
            // set the owning side to null (unless already changed)
            if ($holding->getBooks()->contains($this)) {
                $holding->removeBook($this);
            }
        }

        return $this;
    }

    public function getVariantImprint() : ?string {
        return $this->variantImprint;
    }

    public function setVariantImprint(?string $variantImprint) : self {
        $this->variantImprint = $variantImprint;

        return $this;
    }

    public function getMonarch() : ?Monarch {
        return $this->monarch;
    }

    public function setMonarch(?Monarch $monarch) : self {
        $this->monarch = $monarch;

        return $this;
    }

    public function getEstc() : ?string {
        return $this->estc;
    }

    public function setEstc(?string $estc) : self {
        $this->estc = $estc;

        return $this;
    }

    public function getPhysicalDescription() : ?string {
        return $this->physicalDescription;
    }

    public function setPhysicalDescription(?string $physicalDescription) : self {
        $this->physicalDescription = $physicalDescription;

        return $this;
    }
}
