<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\ORM\Mapping as ORM;
use Nines\UtilBundle\Entity\AbstractEntity;

/**
 * @ORM\Entity(repositoryClass=BookRepository::class)
 */
class Book extends AbstractEntity {

    private $title;

    private $date;

    private $description;

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
