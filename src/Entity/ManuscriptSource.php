<?php

declare(strict_types=1);

/*
 * (c) 2022 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Entity;

use App\Repository\ManuscriptSourceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Nines\MediaBundle\Entity\LinkableInterface;
use Nines\MediaBundle\Entity\LinkableTrait;
use Nines\UtilBundle\Entity\AbstractTerm;

/**
 * @ORM\Entity(repositoryClass=ManuscriptSourceRepository::class)
 */
class ManuscriptSource extends AbstractTerm implements LinkableInterface {
    use LinkableTrait {
        LinkableTrait::__construct as linkable_construct;
    }

    /**
     * @var string
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $callNumber;

    /**
     * @var SourceCategory
     * @ORM\ManyToOne(targetEntity="SourceCategory", inversedBy="manuscriptSources")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sourceCategory;

    /**
     * @var Archive
     * @ORM\ManyToOne(targetEntity="Archive", inversedBy="manuscriptSources")
     * @ORM\JoinColumn(nullable=false)
     */
    private $archive;

    /**
     * @var Collection|Transaction[]
     * @ORM\OneToMany(targetEntity="Transaction", mappedBy="manuscriptSource")
     */
    private $transactions;

    /**
     * @var Collection|Inventory[]
     * @ORM\OneToMany(targetEntity="Inventory", mappedBy="manuscriptSource")
     */
    private $inventories;

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
