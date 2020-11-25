<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ParishRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Nines\UtilBundle\Entity\AbstractEntity;

/**
 * @ORM\Entity(repositoryClass=ParishRepository::class)
 */
class Parish extends AbstractEntity {

    private $name;

    /**
     * @var Collection|Transaction[]
     * @ORM\OneToMany(targetEntity="App\Entity\Transaction", mappedBy="parish")
     */
    private $transactions;

    /**
     * @inheritDoc
     */
    public function __toString() : string {
        return $this->name;
    }

    public function __construct() {
        parent::__construct();
        $this->transactions = new ArrayCollection();
    }

}
