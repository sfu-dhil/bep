<?php

declare(strict_types=1);

/*
 * (c) 2021 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Entity;

use App\Repository\MonarchRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Nines\UtilBundle\Entity\AbstractTerm;

/**
 * @ORM\Entity(repositoryClass=MonarchRepository::class)
 */
class Monarch extends AbstractTerm {
    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Transaction", mappedBy="monarch")
     */
    private $transactions;

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
        $this->inventories = new ArrayCollection();
        $this->books = new ArrayCollection();
    }

    /**
     * @return Collection|transaction[]
     */
    public function getTransactions() : Collection {
        return $this->transactions;
    }

    public function addTransaction(transaction $transaction) : self {
        if ( ! $this->transactions->contains($transaction)) {
            $this->transactions[] = $transaction;
            $transaction->setMonarch($this);
        }

        return $this;
    }

    public function removeTransaction(transaction $transaction) : self {
        if ($this->transactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getMonarch() === $this) {
                $transaction->setMonarch(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|inventory[]
     */
    public function getInventories() : Collection {
        return $this->inventories;
    }

    public function addInventory(inventory $inventory) : self {
        if ( ! $this->inventories->contains($inventory)) {
            $this->inventories[] = $inventory;
            $inventory->setMonarch($this);
        }

        return $this;
    }

    public function removeInventory(inventory $inventory) : self {
        if ($this->inventories->removeElement($inventory)) {
            // set the owning side to null (unless already changed)
            if ($inventory->getMonarch() === $this) {
                $inventory->setMonarch(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Book[]
     */
    public function getBooks(): Collection
    {
        return $this->books;
    }

    public function addBook(Book $book): self
    {
        if (!$this->books->contains($book)) {
            $this->books[] = $book;
            $book->setMonarch($this);
        }

        return $this;
    }

    public function removeBook(Book $book): self
    {
        if ($this->books->removeElement($book)) {
            // set the owning side to null (unless already changed)
            if ($book->getMonarch() === $this) {
                $book->setMonarch(null);
            }
        }

        return $this;
    }
}
