<?php

declare(strict_types=1);

/*
 * (c) 2022 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Entity;

use App\Repository\DioceseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Nines\MediaBundle\Entity\LinkableInterface;
use Nines\MediaBundle\Entity\LinkableTrait;
use Nines\UtilBundle\Entity\AbstractTerm;

/**
 * @ORM\Entity(repositoryClass=DioceseRepository::class)
 */
class Diocese extends AbstractTerm implements LinkableInterface {
    use LinkableTrait {
        LinkableTrait::__construct as linkable_construct;
    }

    /**
     * @var Province
     * @ORM\ManyToOne(targetEntity="Province", inversedBy="dioceses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $province;

    /**
     * @var Archdeaconry[]|Collection
     * @ORM\OneToMany(targetEntity="Archdeaconry", mappedBy="diocese")
     */
    private $archdeaconries;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Injunction", mappedBy="diocese")
     */
    private $injunctions;

    public function __construct() {
        parent::__construct();
        $this->linkable_construct();
        $this->archdeaconries = new ArrayCollection();
        $this->injunctions = new ArrayCollection();
    }

    public function getProvince() : ?Province {
        return $this->province;
    }

    public function setProvince(?Province $province) : self {
        $this->province = $province;

        return $this;
    }

    /**
     * @return Archdeaconry[]|Collection
     */
    public function getArchdeaconries() : Collection {
        return $this->archdeaconries;
    }

    public function addArchdeaconry(Archdeaconry $archdeaconry) : self {
        if ( ! $this->archdeaconries->contains($archdeaconry)) {
            $this->archdeaconries[] = $archdeaconry;
            $archdeaconry->setDiocese($this);
        }

        return $this;
    }

    public function removeArchdeaconry(Archdeaconry $archdeaconry) : self {
        if ($this->archdeaconries->removeElement($archdeaconry)) {
            // set the owning side to null (unless already changed)
            if ($archdeaconry->getDiocese() === $this) {
                $archdeaconry->setDiocese(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Injunction>
     */
    public function getInjunctions() : Collection {
        return $this->injunctions;
    }

    public function addInjunction(Injunction $injunction) : self {
        if ( ! $this->injunctions->contains($injunction)) {
            $this->injunctions[] = $injunction;
            $injunction->setDiocese($this);
        }

        return $this;
    }

    public function removeInjunction(Injunction $injunction) : self {
        if ($this->injunctions->removeElement($injunction)) {
            // set the owning side to null (unless already changed)
            if ($injunction->getDiocese() === $this) {
                $injunction->setDiocese(null);
            }
        }

        return $this;
    }
}
