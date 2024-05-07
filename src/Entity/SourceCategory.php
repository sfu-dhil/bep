<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\SourceCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Nines\UtilBundle\Entity\AbstractTerm;

#[ORM\Entity(repositoryClass: SourceCategoryRepository::class)]
class SourceCategory extends AbstractTerm {
    #[ORM\OneToMany(targetEntity: ManuscriptSource::class, mappedBy: 'sourceCategory')]
    private Collection $manuscriptSources;

    #[ORM\OneToMany(targetEntity: PrintSource::class, mappedBy: 'sourceCategory')]
    private Collection $printSources;

    public function __construct() {
        parent::__construct();
        $this->manuscriptSources = new ArrayCollection();
        $this->printSources = new ArrayCollection();
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
            $manuscriptSource->setSourceCategory($this);
        }

        return $this;
    }

    public function removeSource(ManuscriptSource $manuscriptSource) : self {
        if ($this->manuscriptSources->removeElement($manuscriptSource)) {
            // set the owning side to null (unless already changed)
            if ($manuscriptSource->getSourceCategory() === $this) {
                $manuscriptSource->setSourceCategory(null);
            }
        }

        return $this;
    }

    public function removeManuscriptSource(ManuscriptSource $manuscriptSource) : self {
        if ($this->manuscriptSources->removeElement($manuscriptSource)) {
            // set the owning side to null (unless already changed)
            if ($manuscriptSource->getSourceCategory() === $this) {
                $manuscriptSource->setSourceCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int,PrintSource>
     */
    public function getPrintSources() : Collection {
        return $this->printSources;
    }

    public function addPrintSource(PrintSource $printSource) : self {
        if ( ! $this->printSources->contains($printSource)) {
            $this->printSources[] = $printSource;
            $printSource->setSourceCategory($this);
        }

        return $this;
    }

    public function removePrintSource(PrintSource $printSource) : self {
        if ($this->printSources->removeElement($printSource)) {
            // set the owning side to null (unless already changed)
            if ($printSource->getSourceCategory() === $this) {
                $printSource->setSourceCategory(null);
            }
        }

        return $this;
    }
}
