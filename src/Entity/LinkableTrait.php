<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Exception;
use Nines\MediaBundle\Entity\Link;
use Doctrine\ORM\Mapping as ORM;

trait LinkableTrait {
    #[ORM\Column(type: 'text', nullable: true, name: 'links')]
    private ?string $_links = null;

    /**
     * @var Collection<int,Link>|Link[]
     */
    protected ?Collection $links = null;

    public function __construct() {
        $this->links = new ArrayCollection();
    }

    /**
     * @return array<Link>
     */
    public function getLinks() : array {
        return $this->links->toArray();
    }

    /**
     * @param array<Link>|Collection<int,Link> $links
     *
     * @throws Exception
     */
    public function setLinks($links = null) : self {
        $this->links = new ArrayCollection();
        if ( ! $links) {
            return $this;
        }

        foreach ($links as $link) {
            $this->addLink($link);
        }

        return $this;
    }

    /**
     * @throws Exception
     */
    public function addLink(Link $link) : self {
        $link->setEntity($this);
        $this->links[] = $link;

        return $this;
    }

    public function removeLink(Link $link) : self {
        if ($this->links->contains($link)) {
            $this->links->removeElement($link);
        }

        return $this;
    }
}
