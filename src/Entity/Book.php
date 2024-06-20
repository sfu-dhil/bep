<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Nines\MediaBundle\Entity\LinkableInterface;

use Nines\UtilBundle\Entity\AbstractEntity;

#[ORM\Table]
#[ORM\Index(name: 'book_ft', columns: ['title', 'uniform_title', 'variant_titles', 'description', 'author', 'imprint', 'variant_imprint', 'notes'], flags: ['fulltext'])]
#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book extends AbstractEntity implements LinkableInterface {
    use LinkableTrait {
        LinkableTrait::__construct as linkable_construct;
    }
    use NotesTrait;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $title = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $uniformTitle = null;

    #[ORM\Column(type: 'array')]
    private ?array $variantTitles = [];

    #[ORM\Column(type: 'string', length: 160, nullable: true)]
    private ?string $author = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $imprint = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $variantImprint = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $estc = null;

    #[ORM\Column(type: 'string', length: 12, nullable: true)]
    private ?string $date = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $physicalDescription = null;

    #[ORM\ManyToOne(targetEntity: Format::class, inversedBy: 'books')]
    private ?Format $format = null;

    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    #[ORM\ManyToOne(targetEntity: Monarch::class, inversedBy: 'books')]
    private ?Monarch $monarch = null;

    #[ORM\ManyToMany(targetEntity: Transaction::class, mappedBy: 'books')]
    private Collection $transactions;

    #[ORM\ManyToMany(targetEntity: Inventory::class, mappedBy: 'books')]
    private Collection $inventories;

    #[ORM\ManyToMany(targetEntity: Holding::class, mappedBy: 'books')]
    private Collection $holdings;

    public function __construct() {
        parent::__construct();
        $this->linkable_construct();
        $this->transactions = new ArrayCollection();
        $this->inventories = new ArrayCollection();
        $this->holdings = new ArrayCollection();
    }

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
