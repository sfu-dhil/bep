<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ProvinceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Nines\UtilBundle\Entity\AbstractEntity;
use Nines\UtilBundle\Entity\AbstractTerm;

/**
 * @ORM\Entity(repositoryClass=ProvinceRepository::class)
 */
class Province extends AbstractTerm {

    /**
     * @var Collection|Diocese[]
     * @ORM\OneToMany(targetEntity="App\Entity\Diocese", mappedBy="province")
     */
    private $dioceses;

    public function __construct() {
        parent::__construct();
        $this->dioceses = new ArrayCollection();
    }

    /**
     * @return Collection|Diocese[]
     */
    public function getDioceses(): Collection
    {
        return $this->dioceses;
    }

    public function addDiocese(Diocese $diocese): self
    {
        if (!$this->dioceses->contains($diocese)) {
            $this->dioceses[] = $diocese;
            $diocese->setProvince($this);
        }

        return $this;
    }

    public function removeDiocese(Diocese $diocese): self
    {
        if ($this->dioceses->removeElement($diocese)) {
            // set the owning side to null (unless already changed)
            if ($diocese->getProvince() === $this) {
                $diocese->setProvince(null);
            }
        }

        return $this;
    }

}
