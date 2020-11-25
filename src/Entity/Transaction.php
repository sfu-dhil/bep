<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\TransactionRepository;
use Doctrine\ORM\Mapping as ORM;
use Nines\UtilBundle\Entity\AbstractEntity;

/**
 * @ORM\Entity(repositoryClass=TransactionRepository::class)
 */
class Transaction extends AbstractEntity {

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @var Book
     * @ORM\ManyToOne(targetEntity="App\Entity\Book", inversedBy="transactions")
     */
    private $book;

    /**
     * @var Parish
     * @ORM\ManyToOne(targetEntity="App\Entity\Parish", inversedBy="transactions")
     */
    private $parish;

    /**
     * @inheritDoc
     */
    public function __toString() : string {
        // TODO: Implement __toString() method.
    }

    public function __construct() {
        parent::__construct();
    }

}
