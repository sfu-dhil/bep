<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ManuscriptSourceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Nines\MediaBundle\Entity\LinkableInterface;



#[ORM\Entity(repositoryClass: ManuscriptSourceRepository::class)]
class ManuscriptSource extends AbstractTerm implements LinkableInterface {
    use LinkableTrait {
        LinkableTrait::__construct as linkable_construct;
    }

    #[ORM\Column(type: 'string', length: 64, nullable: true)]
    private ?string $callNumber = null;

    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    #[ORM\ManyToOne(targetEntity: SourceCategory::class, inversedBy: 'manuscriptSources')]
    private ?SourceCategory $sourceCategory = null;

    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    #[ORM\ManyToOne(targetEntity: Archive::class, inversedBy: 'manuscriptSources')]
    private ?Archive $archive = null;

    #[ORM\OneToMany(targetEntity: Transaction::class, mappedBy: 'manuscriptSource')]
    private Collection $transactions;

    #[ORM\OneToMany(targetEntity: Inventory::class, mappedBy: 'manuscriptSource')]
    private Collection $inventories;

    public function __construct() {
        parent::__construct();
        $this->linkable_construct();
        $this->transactions = new ArrayCollection();
        $this->inventories = new ArrayCollection();
    }

    public function getCallNumber() : ?string {
        return $this->callNumber;
    }

    public function setCallNumber(?string $callNumber) : self {
        $this->callNumber = $callNumber;

        return $this;
    }

    public function getSourceCategory() : ?SourceCategory {
        return $this->sourceCategory;
    }

    public function setSourceCategory(?SourceCategory $sourceCategory) : self {
        $this->sourceCategory = $sourceCategory;

        return $this;
    }

    public function getArchive() : ?Archive {
        return $this->archive;
    }

    public function setArchive(?Archive $archive) : self {
        $this->archive = $archive;

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
            $transaction->setManuscriptSource($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction) : self {
        if ($this->transactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getManuscriptSource() === $this) {
                $transaction->setManuscriptSource(null);
            }
        }

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
            $inventory->setManuscriptSource($this);
        }

        return $this;
    }

    public function removeInventory(Inventory $inventory) : self {
        if ($this->inventories->removeElement($inventory)) {
            // set the owning side to null (unless already changed)
            if ($inventory->getManuscriptSource() === $this) {
                $inventory->setManuscriptSource(null);
            }
        }

        return $this;
    }
}
