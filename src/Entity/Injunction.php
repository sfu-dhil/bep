<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\InjunctionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Nines\MediaBundle\Entity\LinkableInterface;
use Nines\MediaBundle\Entity\LinkableTrait;
use Nines\UtilBundle\Entity\AbstractEntity;

#[ORM\Table]
#[ORM\Index(name: 'injunction_ft', columns: ['title', 'uniform_title', 'variant_titles', 'transcription', 'modern_transcription', 'author', 'imprint', 'variant_imprint'], flags: ['fulltext'])]
#[ORM\Entity(repositoryClass: InjunctionRepository::class)]
class Injunction extends AbstractEntity implements LinkableInterface {
    use LinkableTrait {
        LinkableTrait::__construct as linkable_constructor;
    }
    use NotesTrait;

    #[ORM\Column(type: 'text')]
    private ?string $title = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $uniformTitle = null;

    #[ORM\Column(type: 'array')]
    private ?array $variantTitles = [];

    #[ORM\Column(type: 'string', length: 160, nullable: true)]
    private ?string $author = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $imprint = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $variantImprint = null;

    #[ORM\Column(type: 'string', length: 12, nullable: true)]
    private ?string $date = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $physicalDescription = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $transcription = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $modernTranscription = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $estc = null;

    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    #[ORM\ManyToOne(targetEntity: Nation::class, inversedBy: 'injunctions')]
    private ?Nation $nation = null;

    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    #[ORM\ManyToOne(targetEntity: Diocese::class, inversedBy: 'injunctions')]
    private ?Diocese $diocese = null;

    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    #[ORM\ManyToOne(targetEntity: Province::class, inversedBy: 'injunctions')]
    private ?Province $province = null;

    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    #[ORM\ManyToOne(targetEntity: Archdeaconry::class, inversedBy: 'injunctions')]
    private ?Archdeaconry $archdeaconry = null;

    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    #[ORM\ManyToOne(targetEntity: Monarch::class, inversedBy: 'injunctions')]
    private ?Monarch $monarch = null;

    #[ORM\OneToMany(targetEntity: Transaction::class, mappedBy: 'injunction')]
    private Collection $transactions;

    #[ORM\OneToMany(targetEntity: Inventory::class, mappedBy: 'injunction')]
    private Collection $inventories;

    public function __construct() {
        parent::__construct();
        $this->linkable_constructor();
        $this->transactions = new ArrayCollection();
        $this->inventories = new ArrayCollection();
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

    public function getTranscription() : ?string {
        return $this->transcription;
    }

    public function setTranscription(string $transcription) : self {
        $this->transcription = $transcription;

        return $this;
    }

    public function getModernTranscription() : ?string {
        return $this->modernTranscription;
    }

    public function setModernTranscription(?string $modernTranscription) : self {
        $this->modernTranscription = $modernTranscription;

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

    public function getMonarch() : ?Monarch {
        return $this->monarch;
    }

    public function setMonarch(?Monarch $monarch) : self {
        $this->monarch = $monarch;

        return $this;
    }

    public function getPhysicalDescription() : ?string {
        return $this->physicalDescription;
    }

    public function setPhysicalDescription(?string $physicalDescription) : self {
        $this->physicalDescription = $physicalDescription;

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
            $inventory->setInjunction($this);
        }

        return $this;
    }

    public function removeInventory(Inventory $inventory) : self {
        if ($this->inventories->removeElement($inventory)) {
            // set the owning side to null (unless already changed)
            if ($inventory->getInjunction() === $this) {
                $inventory->setInjunction(null);
            }
        }

        return $this;
    }

    public function getNation() : ?Nation {
        return $this->nation;
    }

    public function setNation(?Nation $nation) : self {
        $this->nation = $nation;

        return $this;
    }

    public function getDiocese() : ?Diocese {
        return $this->diocese;
    }

    public function setDiocese(?Diocese $diocese) : self {
        $this->diocese = $diocese;

        return $this;
    }

    public function getProvince() : ?Province {
        return $this->province;
    }

    public function setProvince(?Province $province) : self {
        $this->province = $province;

        return $this;
    }

    public function getArchdeaconry() : ?Archdeaconry {
        return $this->archdeaconry;
    }

    public function setArchdeaconry(?Archdeaconry $archdeaconry) : self {
        $this->archdeaconry = $archdeaconry;

        return $this;
    }
}
