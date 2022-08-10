<?php

declare(strict_types=1);

/*
 * (c) 2022 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Entity;

use App\Repository\MonarchRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Nines\UtilBundle\Entity\AbstractTerm;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=MonarchRepository::class)
 */
class Monarch extends AbstractTerm {
    /**
     * @var string
     * @ORM\Column(type="string", length=10, nullable=true)
     * @Assert\Date(message="{{ value }} is not a valid value. It must be formatted as yyyy-mm-dd and be a valid date.")
     */
    private $startDate;

    /**
     * @var string
     * @ORM\Column(type="string", length=10, nullable=true)
     * @Assert\Date(message="{{ value }} is not a valid value. It must be formatted as yyyy-mm-dd and be a valid date.")
     */
    private $endDate;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Transaction", mappedBy="monarch")
     */
    private $transactions;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Injunction", mappedBy="monarch")
     */
    private $injunctions;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Inventory", mappedBy="monarch")
     */
    private $inventories;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Book", mappedBy="monarch")
     */
    private $books;

    public function __construct() {
        parent::__construct();
        $this->transactions = new ArrayCollection();
        $this->injunctions = new ArrayCollection();
        $this->inventories = new ArrayCollection();
        $this->books = new ArrayCollection();
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
            $transaction->setMonarch($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction) : self {
        if ($this->transactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getMonarch() === $this) {
                $transaction->setMonarch(null);
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
            $inventory->setMonarch($this);
        }

        return $this;
    }

    public function removeInventory(Inventory $inventory) : self {
        if ($this->inventories->removeElement($inventory)) {
            // set the owning side to null (unless already changed)
            if ($inventory->getMonarch() === $this) {
                $inventory->setMonarch(null);
            }
        }

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
            $book->setMonarch($this);
        }

        return $this;
    }

    public function removeBook(Book $book) : self {
        if ($this->books->removeElement($book)) {
            // set the owning side to null (unless already changed)
            if ($book->getMonarch() === $this) {
                $book->setMonarch(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Injunction[]
     */
    public function getInjunctions() : Collection {
        return $this->injunctions;
    }

    public function addInjunction(Injunction $injunction) : self {
        if ( ! $this->injunctions->contains($injunction)) {
            $this->injunctions[] = $injunction;
            $injunction->setMonarch($this);
        }

        return $this;
    }

    public function removeInjunction(Injunction $injunction) : self {
        if ($this->injunctions->removeElement($injunction)) {
            // set the owning side to null (unless already changed)
            if ($injunction->getMonarch() === $this) {
                $injunction->setMonarch(null);
            }
        }

        return $this;
    }

    public function getStartDate() : ?string {
        return $this->startDate;
    }

    public function setStartDate(?string $startDate) : self {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate() : ?string {
        return $this->endDate;
    }

    public function setEndDate(?string $endDate) : self {
        $this->endDate = $endDate;

        return $this;
    }
}
