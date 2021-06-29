<?php

declare(strict_types=1);

/*
 * (c) 2021 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Entity;

use App\Repository\InjunctionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Nines\MediaBundle\Entity\LinkableInterface;
use Nines\MediaBundle\Entity\LinkableTrait;
use Nines\UtilBundle\Entity\AbstractEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=InjunctionRepository::class)
 * @ORM\Table(indexes={
 *     @ORM\Index(name="injunction_ft", columns={"title", "description", "estc"}, flags={"fulltext"})
 * })
 */
class Injunction extends AbstractEntity implements LinkableInterface {
    use LinkableTrait {
        LinkableTrait::__construct as linkable_constructor;
    }

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @var string
     * @Assert\Url
     * @ORM\Column(type="string", nullable=true)
     */
    private $estc;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="App\Entity\Transaction", mappedBy="injunction")
     */
    private $transactions;

    public function __construct() {
        parent::__construct();
        $this->linkable_constructor();
        $this->transactions = new ArrayCollection();
    }

    /**
     * {@inheritDoc}
     */
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

    public function getDescription() : ?string {
        return $this->description;
    }

    public function setDescription(string $description) : self {
        $this->description = $description;

        return $this;
    }

    public function getEstc() : ?string {
        return $this->estc;
    }

    public function setEstc(?string $estc) : self {
        $this->estc = $estc;

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
            $transaction->setInjunction($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction) : self {
        if ($this->transactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getInjunction() === $this) {
                $transaction->setInjunction(null);
            }
        }

        return $this;
    }
}
