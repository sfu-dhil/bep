<?php

declare(strict_types=1);

/*
 * (c) 2020 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Entity;

use App\Repository\SourceCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Nines\UtilBundle\Entity\AbstractTerm;

/**
 * @ORM\Entity(repositoryClass=SourceCategoryRepository::class)
 */
class SourceCategory extends AbstractTerm {
    /**
     * @var Collection|Source[]
     * @ORM\OneToMany(targetEntity="Source", mappedBy="sourceCategory")
     */
    private $sources;

    public function __construct() {
        parent::__construct();
        $this->sources = new ArrayCollection();
    }

    /**
     * @return Collection|Source[]
     */
    public function getSources() : Collection {
        return $this->sources;
    }

    public function addSource(Source $source) : self {
        if ( ! $this->sources->contains($source)) {
            $this->sources[] = $source;
            $source->setSourceCategory($this);
        }

        return $this;
    }

    public function removeSource(Source $source) : self {
        if ($this->sources->removeElement($source)) {
            // set the owning side to null (unless already changed)
            if ($source->getSourceCategory() === $this) {
                $source->setSourceCategory(null);
            }
        }

        return $this;
    }
}
