<?php

declare(strict_types=1);

/*
 * (c) 2020 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Entity;

use App\Repository\CountyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Nines\MediaBundle\Entity\LinkableInterface;
use Nines\MediaBundle\Entity\LinkableTrait;
use Nines\UtilBundle\Entity\AbstractTerm;

/**
 * @ORM\Entity(repositoryClass=CountyRepository::class)
 */
class County extends AbstractTerm implements LinkableInterface
{
    use LinkableTrait {
        LinkableTrait::__construct as linkable_construct;
    }

    /**
     * @var Nation
     * @ORM\ManyToOne(targetEntity="Nation", inversedBy="counties")
     * @ORM\JoinColumn(nullable=false)
     */
    private $nation;

    /**
     * @var Collection|Parish[]
     * @ORM\OneToMany(targetEntity="App\Entity\Town", mappedBy="county")
     */
    private $towns;

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
