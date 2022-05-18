<?php

declare(strict_types=1);

/*
 * (c) 2021 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Entity;

use App\Repository\ArchiveRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Nines\MediaBundle\Entity\LinkableInterface;
use Nines\MediaBundle\Entity\LinkableTrait;
use Nines\UtilBundle\Entity\AbstractTerm;

/**
 * @ORM\Entity(repositoryClass=ArchiveRepository::class)
 */
class Archive extends AbstractTerm implements LinkableInterface {
    use LinkableTrait {
        LinkableTrait::__construct as linkable_constructor;
    }

    /**
     * @var Collection|ManuscriptSource[]
     * @ORM\OneToMany(targetEntity="ManuscriptSource", mappedBy="archive")
     */
    private $manuscriptSources;

    /**
     * @var Collection|Holding[]
     * @ORM\OneToMany(targetEntity="Holding", mappedBy="archive")
     */
    private $holdings;

    public function __construct() {
        parent::__construct();
        $this->linkable_constructor();
        $this->manuscriptSources = new ArrayCollection();
        $this->holdings = new ArrayCollection();
    }

    /**
     * @return Collection|ManuscriptSource[]
     */
    public function getManuscriptSources() : Collection {
        return $this->manuscriptSources;
    }

    public function addManuscriptSource(ManuscriptSource $manuscriptSource) : self {
        if ( ! $this->manuscriptSources->contains($manuscriptSource)) {
            $this->manuscriptSources[] = $manuscriptSource;
            $manuscriptSource->setArchive($this);
        }

        return $this;
    }

    public function removeManuscriptSource(ManuscriptSource $manuscriptSource) : self {
        if ($this->manuscriptSources->removeElement($manuscriptSource)) {
            // set the owning side to null (unless already changed)
            if ($manuscriptSource->getArchive() === $this) {
                $manuscriptSource->setArchive(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Holding[]
     */
    public function getHoldings() : Collection {
        return $this->holdings;
    }

    public function addHolding(Holding $holding) : self {
        if ( ! $this->holdings->contains($holding)) {
            $this->holdings[] = $holding;
            $holding->setArchive($this);
        }

        return $this;
    }

    public function removeHolding(Holding $holding) : self {
        if ($this->holdings->removeElement($holding)) {
            // set the owning side to null (unless already changed)
            if ($holding->getArchive() === $this) {
                $holding->setArchive(null);
            }
        }

        return $this;
    }
}
