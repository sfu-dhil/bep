<?php

declare(strict_types=1);

/*
 * (c) 2020 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Entity;

use App\Repository\ParishRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Nines\MediaBundle\Entity\LinkableInterface;
use Nines\MediaBundle\Entity\LinkableTrait;
use Nines\UtilBundle\Entity\AbstractTerm;

/**
 * @ORM\Entity(repositoryClass=ParishRepository::class)
 */
class Parish extends AbstractTerm implements LinkableInterface {

    use LinkableTrait {
        LinkableTrait::__construct as linkable_construct;
    }
    /**
     * @var Archdeaconry
     * @ORM\ManyToOne(targetEntity="App\Entity\Archdeaconry", inversedBy="parishes")
     */
    private $archdeaconry;

    /**
     * A county outside City of London, or a ward inside London.
     *
     * @var Town
     * @ORM\ManyToOne(targetEntity="App\Entity\Town", inversedBy="parishes")
     */
    private $town;

    /**
     * @var Collection|Transaction[]
     * @ORM\OneToMany(targetEntity="App\Entity\Transaction", mappedBy="parish")
     */
    private $transactions;

    public function __construct() {
        parent::__construct();
        $this->linkable_construct();
        $this->transactions = new ArrayCollection();
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
}
