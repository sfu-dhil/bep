<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\TransactionCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: TransactionCategoryRepository::class)]
class TransactionCategory extends AbstractTerm {
    #[ORM\ManyToMany(targetEntity: Transaction::class, mappedBy: 'transactionCategories')]
    private Collection $transactions;

    public function __construct() {
        parent::__construct();
        $this->transactions = new ArrayCollection();
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
            $transaction->addTransactionCategory($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction) : self {
        if ($this->transactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getTransactionCategories()->contains($this)) {
                $transaction->getTransactionCategories()->remove($this);
            }
        }

        return $this;
    }
}
