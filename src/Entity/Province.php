<?php

declare(strict_types=1);

/*
 * (c) 2021 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Entity;

use App\Repository\ProvinceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Nines\MediaBundle\Entity\LinkableInterface;
use Nines\MediaBundle\Entity\LinkableTrait;
use Nines\UtilBundle\Entity\AbstractTerm;

/**
 * @ORM\Entity(repositoryClass=ProvinceRepository::class)
 */
class Province extends AbstractTerm implements LinkableInterface {
    use LinkableTrait {
        LinkableTrait::__construct as linkable_construct;

    }

    /**
     * @var Nation
     * @ORM\ManyToOne(targetEntity="Nation", inversedBy="provinces")
     * @ORM\JoinColumn(nullable=false)
     */
    private $nation;

    /**
     * @var Collection|Diocese[]
     * @ORM\OneToMany(targetEntity="App\Entity\Diocese", mappedBy="province")
     */
    private $dioceses;

    public function __construct() {
        parent::__construct();
        $this->linkable_construct();
        $this->dioceses = new ArrayCollection();
    }

    /**
     * @return Collection|Diocese[]
     */
    public function getDioceses() : Collection {
        return $this->dioceses;
    }

    public function addDiocese(Diocese $diocese) : self {
        if ( ! $this->dioceses->contains($diocese)) {
            $this->dioceses[] = $diocese;
            $diocese->setProvince($this);
        }

        return $this;
    }

    public function removeDiocese(Diocese $diocese) : self {
        if ($this->dioceses->removeElement($diocese)) {
            // set the owning side to null (unless already changed)
            if ($diocese->getProvince() === $this) {
                $diocese->setProvince(null);
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
