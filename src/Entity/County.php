<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\CountyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Nines\UtilBundle\Entity\AbstractEntity;
use Nines\UtilBundle\Entity\AbstractTerm;

/**
 * @ORM\Entity(repositoryClass=CountyRepository::class)
 */
class County extends AbstractTerm {

    /**
     * @var boolean;
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $inLondon;

    /**
     * @var Collection|Parish[]
     * @ORM\OneToMany(targetEntity="App\Entity\Parish", mappedBy="county")
     */
    private $parishes;

    public function __construct() {
        parent::__construct();
        $this->inLondon = false;
        $this->parishes = new ArrayCollection();
    }

    public function getInLondon(): ?bool
    {
        return $this->inLondon;
    }

    public function setInLondon(bool $inLondon): self
    {
        $this->inLondon = $inLondon;

        return $this;
    }

    /**
     * @return Collection|Parish[]
     */
    public function getParishes(): Collection
    {
        return $this->parishes;
    }

    public function addParish(Parish $parish): self
    {
        if (!$this->parishes->contains($parish)) {
            $this->parishes[] = $parish;
            $parish->setCounty($this);
        }

        return $this;
    }

    public function removeParish(Parish $parish): self
    {
        if ($this->parishes->removeElement($parish)) {
            // set the owning side to null (unless already changed)
            if ($parish->getCounty() === $this) {
                $parish->setCounty(null);
            }
        }

        return $this;
    }

}
