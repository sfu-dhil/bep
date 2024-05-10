<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ParishRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Nines\MediaBundle\Entity\LinkableInterface;
use Nines\MediaBundle\Entity\LinkableTrait;
use Nines\UtilBundle\Entity\AbstractTerm;

#[ORM\Entity(repositoryClass: ParishRepository::class)]
class Parish extends AbstractTerm implements LinkableInterface {
    use LinkableTrait {
        LinkableTrait::__construct as linkable_construct;
    }

    #[ORM\Column(type: 'decimal', precision: 10, scale: 7, nullable: true)]
    private ?string $latitude = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 7, nullable: true)]
    private ?string $longitude = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $address = null;

    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    #[ORM\ManyToOne(targetEntity: Archdeaconry::class, inversedBy: 'parishes')]
    private ?Archdeaconry $archdeaconry = null;

    /**
     * A county outside City of London, or a ward inside London.
     */
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    #[ORM\ManyToOne(targetEntity: Town::class, inversedBy: 'parishes')]
    private ?Town $town = null;

    #[ORM\OneToMany(targetEntity: Transaction::class, mappedBy: 'parish')]
    private Collection $transactions;

    #[ORM\OneToMany(targetEntity: Inventory::class, mappedBy: 'parish')]
    private Collection $inventories;

    #[ORM\OneToMany(targetEntity: Holding::class, mappedBy: 'parish')]
    private Collection $holdings;

    public function __construct() {
        parent::__construct();
        $this->linkable_construct();
        $this->transactions = new ArrayCollection();
        $this->inventories = new ArrayCollection();
        $this->holdings = new ArrayCollection();
    }

    public function getArchdeaconry() : ?Archdeaconry {
        return $this->archdeaconry;
    }

    public function setArchdeaconry(?Archdeaconry $archdeaconry) : self {
        $this->archdeaconry = $archdeaconry;

        return $this;
    }

    public function getTown() : ?Town {
        return $this->town;
    }

    public function setTown(?Town $town) : self {
        $this->town = $town;

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
            $transaction->setParish($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction) : self {
        if ($this->transactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getParish() === $this) {
                $transaction->setParish(null);
            }
        }

        return $this;
    }

    public function getLatitude() : ?string {
        return $this->latitude;
    }

    public function setLatitude(?string $latitude) : self {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude() : ?string {
        return $this->longitude;
    }

    public function setLongitude(?string $longitude) : self {
        $this->longitude = $longitude;

        return $this;
    }

    public function getAddress() : ?string {
        return $this->address;
    }

    public function setAddress(?string $address) : self {
        $this->address = $address;

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
            $inventory->setParish($this);
        }

        return $this;
    }

    public function removeInventory(Inventory $inventory) : self {
        if ($this->inventories->removeElement($inventory)) {
            // set the owning side to null (unless already changed)
            if ($inventory->getParish() === $this) {
                $inventory->setParish(null);
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
            $holding->setParish($this);
        }

        return $this;
    }

    public function removeHolding(Holding $holding) : self {
        if ($this->holdings->removeElement($holding)) {
            // set the owning side to null (unless already changed)
            if ($holding->getParish() === $this) {
                $holding->setParish(null);
            }
        }

        return $this;
    }
}
