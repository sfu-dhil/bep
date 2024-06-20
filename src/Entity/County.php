<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\CountyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Nines\MediaBundle\Entity\LinkableInterface;



#[ORM\Entity(repositoryClass: CountyRepository::class)]
class County extends AbstractTerm implements LinkableInterface {
    use LinkableTrait {
        LinkableTrait::__construct as linkable_construct;
    }

    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    #[ORM\ManyToOne(targetEntity: Nation::class, inversedBy: 'counties')]
    private ?Nation $nation = null;

    #[ORM\OneToMany(targetEntity: Town::class, mappedBy: 'county')]
    private Collection $towns;

    public function __construct() {
        parent::__construct();
        $this->linkable_construct();
        $this->towns = new ArrayCollection();
    }

    /**
     * @return Collection|Town[]
     */
    public function getTowns() : Collection {
        return $this->towns;
    }

    public function addTown(Town $town) : self {
        if ( ! $this->towns->contains($town)) {
            $this->towns[] = $town;
            $town->setCounty($this);
        }

        return $this;
    }

    public function removeTown(Town $town) : self {
        if ($this->towns->removeElement($town)) {
            // set the owning side to null (unless already changed)
            if ($town->getCounty() === $this) {
                $town->setCounty(null);
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
}
