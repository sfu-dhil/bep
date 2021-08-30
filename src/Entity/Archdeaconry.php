<?php

declare(strict_types=1);

/*
 * (c) 2021 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Entity;

use App\Repository\ArchdeaconryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Nines\MediaBundle\Entity\LinkableInterface;
use Nines\MediaBundle\Entity\LinkableTrait;
use Nines\UtilBundle\Entity\AbstractTerm;

/**
 * @ORM\Entity(repositoryClass=ArchdeaconryRepository::class)
 */
class Archdeaconry extends AbstractTerm implements LinkableInterface {
    use LinkableTrait {
        LinkableTrait::__construct as linkable_construct;

    }

    /**
     * @var Diocese
     * @ORM\ManyToOne(targetEntity="App\Entity\Diocese", inversedBy="archdeaconries")
     * @ORM\JoinColumn(nullable=false)
     */
    private $diocese;

    /**
     * @var Collection|Parish[]
     * @ORM\OneToMany(targetEntity="App\Entity\Parish", mappedBy="archdeaconry")
     */
    private $parishes;

    public function __construct() {
        parent::__construct();
        $this->linkable_construct();
        $this->parishes = new ArrayCollection();
    }

    public function getDiocese() : ?Diocese {
        return $this->diocese;
    }

    public function setDiocese(?Diocese $diocese) : self {
        $this->diocese = $diocese;

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
            $parish->setArchdeaconry($this);
        }

        return $this;
    }

    public function removeParish(Parish $parish) : self {
        if ($this->parishes->removeElement($parish)) {
            // set the owning side to null (unless already changed)
            if ($parish->getArchdeaconry() === $this) {
                $parish->setArchdeaconry(null);
            }
        }

        return $this;
    }
}
