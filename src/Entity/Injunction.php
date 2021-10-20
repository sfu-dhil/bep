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

/**
 * @ORM\Entity(repositoryClass=InjunctionRepository::class)
 * @ORM\Table(indexes={
 *     @ORM\Index(name="injunction_ft", columns={"title", "uniform_title", "variant_titles", "description", "author", "imprint", "variant_imprint"}, flags={"fulltext"})
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
     * @ORM\Column(type="text", nullable=true)
     */
    private $uniformTitle;

    /**
     * @var array
     * @ORM\Column(type="array")
     */
    private $variantTitles;

    /**
     * @var string
     * @ORM\Column(type="string", length=160, nullable=true)
     */
    private $author;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $imprint;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $variantImprint;

    /**
     * @var string
     * @ORM\Column(type="string", length=12, nullable=true)
     */
    private $date;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @var string
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
        $this->variantTitles = [];
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

    public function getUniformTitle() : ?string {
        return $this->uniformTitle;
    }

    public function setUniformTitle(?string $uniformTitle) : self {
        $this->uniformTitle = $uniformTitle;

        return $this;
    }

    public function getVariantTitles() : ?array {
        return $this->variantTitles;
    }

    public function setVariantTitles(array $variantTitles) : self {
        $this->variantTitles = $variantTitles;

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

    public function getVariantImprint() : ?string {
        return $this->variantImprint;
    }

    public function setVariantImprint(?string $variantImprint) : self {
        $this->variantImprint = $variantImprint;

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
