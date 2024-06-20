<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\PrintSourceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Nines\MediaBundle\Entity\LinkableInterface;

use Nines\UtilBundle\Entity\AbstractEntity;

#[ORM\Table]
#[ORM\Index(name: 'print_source_ft', columns: ['title', 'author', 'publisher'], flags: ['fulltext'])]
#[ORM\Entity(repositoryClass: PrintSourceRepository::class)]
class PrintSource extends AbstractEntity implements LinkableInterface {
    use NotesTrait;
    use LinkableTrait {__construct as linkable_constructor; }

    #[ORM\Column(type: 'string', length: 200, nullable: false)]
    private string $title = '';

    #[ORM\Column(type: 'string', length: 200, nullable: true)]
    private ?string $author = null;

    #[ORM\Column(type: 'string', length: 16, nullable: true)]
    private ?string $date = null;

    #[ORM\Column(type: 'string', length: 200, nullable: true)]
    private ?string $publisher = null;

    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    #[ORM\ManyToOne(targetEntity: SourceCategory::class, inversedBy: 'printSources')]
    private ?SourceCategory $sourceCategory = null;

    #[ORM\OneToMany(targetEntity: Transaction::class, mappedBy: 'printSource')]
    private Collection $transactions;

    #[ORM\OneToMany(targetEntity: Inventory::class, mappedBy: 'printSource')]
    private Collection $inventories;

    public function __construct() {
        parent::__construct();
        $this->transactions = new ArrayCollection();
        $this->inventories = new ArrayCollection();
        $this->linkable_constructor();
    }

    public function __toString() : string {
        return $this->title;
    }

    public function getTitle() : ?string {
        return $this->title;
    }

    public function setTitle(string $title) : self {
        $this->title = $title;

        return $this;
    }

    public function getAuthor() : ?string {
        return $this->author;
    }

    public function setAuthor(?string $author) : self {
        $this->author = $author;

        return $this;
    }

    public function getDate() : ?string {
        return $this->date;
    }

    public function setDate(?string $date) : self {
        $this->date = $date;

        return $this;
    }

    public function getPublisher() : ?string {
        return $this->publisher;
    }

    public function setPublisher(?string $publisher) : self {
        $this->publisher = $publisher;

        return $this;
    }

    public function getSourceCategory() : ?SourceCategory {
        return $this->sourceCategory;
    }

    public function setSourceCategory(?SourceCategory $sourceCategory) : self {
        $this->sourceCategory = $sourceCategory;

        return $this;
    }

    /**
     * @return Collection<int,Transaction>
     */
    public function getTransactions() : Collection {
        return $this->transactions;
    }

    public function addTransaction(Transaction $transaction) : self {
        if ( ! $this->transactions->contains($transaction)) {
            $this->transactions[] = $transaction;
            $transaction->setPrintSource($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction) : self {
        if ($this->transactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getPrintSource() === $this) {
                $transaction->setPrintSource(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int,Inventory>
     */
    public function getInventories() : Collection {
        return $this->inventories;
    }

    public function addInventory(Inventory $inventory) : self {
        if ( ! $this->inventories->contains($inventory)) {
            $this->inventories[] = $inventory;
            $inventory->setPrintSource($this);
        }

        return $this;
    }

    public function removeInventory(Inventory $inventory) : self {
        if ($this->inventories->removeElement($inventory)) {
            // set the owning side to null (unless already changed)
            if ($inventory->getPrintSource() === $this) {
                $inventory->setPrintSource(null);
            }
        }

        return $this;
    }
}
