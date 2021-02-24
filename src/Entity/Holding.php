<?php

declare(strict_types=1);

/*
 * (c) 2020 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Entity;

use App\Repository\HoldingRepository;
use Doctrine\ORM\Mapping as ORM;
use Nines\MediaBundle\Entity\ImageContainerInterface;
use Nines\MediaBundle\Entity\ImageContainerTrait;
use Nines\UtilBundle\Entity\AbstractEntity;

/**
 * @ORM\Entity(repositoryClass=HoldingRepository::class)
 */
class Holding extends AbstractEntity implements ImageContainerInterface {
    use ImageContainerTrait {
        ImageContainerTrait::__construct as protected trait_constructor;
    }
    use DatedTrait;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @var Parish
     * @ORM\ManyToOne(targetEntity="App\Entity\Parish", inversedBy="holdings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $parish;

    /**
     * @var Book
     * @ORM\ManyToOne(targetEntity="App\Entity\Book", inversedBy="holdings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $book;

    /**
     * @var Archive
     * @ORM\ManyToOne(targetEntity="App\Entity\Archive", inversedBy="holdings")
     */
    private $archive;

    public function __construct() {
        parent::__construct();
        $this->trait_constructor();
    }

    /**
     * {@inheritDoc}
     */
    public function __toString() : string {
        return $this->book . ' ' . $this->parish;
    }

    public function getDescription() : ?string {
        return $this->description;
    }

    public function setDescription(string $description) : self {
        $this->description = $description;

        return $this;
    }

    public function getParish() : ?Parish {
        return $this->parish;
    }

    public function setParish(?Parish $parish) : self {
        $this->parish = $parish;

        return $this;
    }

    public function getBook() : ?Book {
        return $this->book;
    }

    public function setBook(?Book $book) : self {
        $this->book = $book;

        return $this;
    }

    public function getArchive(): ?Archive
    {
        return $this->archive;
    }

    public function setArchive(?Archive $archive): self
    {
        $this->archive = $archive;

        return $this;
    }
}
