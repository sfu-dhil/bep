<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\TownRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Nines\MediaBundle\Entity\LinkableInterface;



#[ORM\Entity(repositoryClass: TownRepository::class)]
class Town extends AbstractTerm implements LinkableInterface {
    use LinkableTrait {
        LinkableTrait::__construct as linkable_construct;
    }

    #[ORM\Column(type: 'boolean', nullable: false)]
    private bool $inLondon = false;

    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    #[ORM\ManyToOne(targetEntity: County::class, inversedBy: 'towns')]
    private ?County $county = null;

    /**
     * @var Collection<int,Parish>
     */
    #[ORM\OneToMany(targetEntity: Parish::class, mappedBy: 'town')]
    private Collection $parishes;

    public function __construct() {
        parent::__construct();
        $this->linkable_construct();
        $this->parishes = new ArrayCollection();
    }

    public function getInLondon() : ?bool {
        return $this->inLondon;
    }

    public function setInLondon(bool $inLondon) : self {
        $this->inLondon = $inLondon;

        return $this;
    }

    public function getCounty() : ?County {
        return $this->county;
    }

    public function setCounty(?County $county) : self {
        $this->county = $county;

        return $this;
    }

    /**
     * @return Collection|Parish[]
     */
    public function getParishes() : Collection {
        return $this->parishes;
    }

    public function addParish(Parish $parish) : self {
        if ( ! $this->parishes->contains($parish)) {
            $this->parishes[] = $parish;
            $parish->setTown($this);
        }

        return $this;
    }

    public function removeParish(Parish $parish) : self {
        if ($this->parishes->removeElement($parish)) {
            // set the owning side to null (unless already changed)
            if ($parish->getTown() === $this) {
                $parish->setTown(null);
            }
        }

        return $this;
    }
}
