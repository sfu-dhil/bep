<?php

declare(strict_types=1);

/*
 * (c) 2020 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Entity;

use App\Repository\NationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Nines\UtilBundle\Entity\AbstractTerm;

/**
 * @ORM\Entity(repositoryClass=NationRepository::class)
 */
class Nation extends AbstractTerm {
    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Province", mappedBy="nation")
     */
    private $provinces;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="County", mappedBy="nation")
     */
    private $counties;

    public function __construct() {
        parent::__construct();
        $this->provinces = new ArrayCollection();
        $this->counties = new ArrayCollection();
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
}
