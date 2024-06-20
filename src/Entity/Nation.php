<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\NationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: NationRepository::class)]
class Nation extends AbstractTerm {
    #[ORM\OneToMany(targetEntity: Province::class, mappedBy: 'nation')]
    private Collection $provinces;

    #[ORM\OneToMany(targetEntity: County::class, mappedBy: 'nation')]
    private Collection $counties;

    #[ORM\OneToMany(targetEntity: Injunction::class, mappedBy: 'nation')]
    private Collection $injunctions;

    public function __construct() {
        parent::__construct();
        $this->provinces = new ArrayCollection();
        $this->counties = new ArrayCollection();
        $this->injunctions = new ArrayCollection();
    }

    /**
     * @return Collection|Province[]
     */
    public function getProvinces() : Collection {
        return $this->provinces;
    }

    public function addProvince(Province $province) : self {
        if ( ! $this->provinces->contains($province)) {
            $this->provinces[] = $province;
            $province->setNation($this);
        }

        return $this;
    }

    public function removeProvince(Province $province) : self {
        if ($this->provinces->removeElement($province)) {
            // set the owning side to null (unless already changed)
            if ($province->getNation() === $this) {
                $province->setNation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|County[]
     */
    public function getCounties() : Collection {
        return $this->counties;
    }

    public function addCounty(County $county) : self {
        if ( ! $this->counties->contains($county)) {
            $this->counties[] = $county;
            $county->setNation($this);
        }

        return $this;
    }

    public function removeCounty(County $county) : self {
        if ($this->counties->removeElement($county)) {
            // set the owning side to null (unless already changed)
            if ($county->getNation() === $this) {
                $county->setNation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int,Injunction>
     */
    public function getInjunctions() : Collection {
        return $this->injunctions;
    }

    public function addInjunction(Injunction $injunction) : self {
        if ( ! $this->injunctions->contains($injunction)) {
            $this->injunctions[] = $injunction;
            $injunction->setNation($this);
        }

        return $this;
    }

    public function removeInjunction(Injunction $injunction) : self {
        if ($this->injunctions->removeElement($injunction)) {
            // set the owning side to null (unless already changed)
            if ($injunction->getNation() === $this) {
                $injunction->setNation(null);
            }
        }

        return $this;
    }
}
