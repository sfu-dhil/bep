<?php

declare(strict_types=1);

/*
 * (c) 2020 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Entity;

use App\Repository\TransactionRepository;
use Doctrine\ORM\Mapping as ORM;
use Nines\UtilBundle\Entity\AbstractEntity;

/**
 * @ORM\Entity(repositoryClass=TransactionRepository::class)
 * @ORM\Table(name="transact")
 */
class Transaction extends AbstractEntity {
    /**
     * Price of the transaction in pennies.
     *
     * £2. 3s. 6d. (two pounds, three shillings and six pence) is recorded as
     *
     * 2 * 240 + 3 * 12 + 6 = 522
     *
     * @var int
     * @ORM\Column(type="integer", nullable=true)
     */
    private $value;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     */
    private $copies;

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
     * @var TransactionCategory
     * @ORM\ManyToOne(targetEntity="App\Entity\TransactionCategory", inversedBy="transactions")
     */
    private $transactionCategory;

    public function __construct() {
        parent::__construct();
        $this->copies = 1;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString() : string {
        return 'Transaction ' . $this->id;
    }

    public function getValue($format = false, $list = false) {
        if ($format) {
            $l = floor($this->value / 240);
            $s = floor(($this->value - $l * 240) / 12);
            $d = $this->value - $s * 12 - $l * 240;
            if($list) {
                return [$l, $s, $d];
            } else {
                return "£{$l}. {$s}s. {$d}d";
            }
        }

        return $this->value;
    }

    public function setValue(?int $value) : self {
        $this->value = $value;

        return $this;
    }

    public function setLsd(int $l, int $s, int $d) : self {
        $this->value = 240 * $l + 12 * $s + $d;

        return $this;
    }

    public function getDescription() : ?string {
        return $this->description;
    }

    public function setDescription(?string $description) : self {
        $this->description = $description;

        return $this;
    }

    public function getBook() : ?Book {
        return $this->book;
    }

    public function setBook(?Book $book) : self {
        $this->book = $book;

        return $this;
    }

    public function getParish() : ?Parish {
        return $this->parish;
    }

    public function setParish(?Parish $parish) : self {
        $this->parish = $parish;

        return $this;
    }

    public function getTransactionCategory() : ?TransactionCategory {
        return $this->transactionCategory;
    }

    public function setTransactionCategory(?TransactionCategory $transactionCategory) : self {
        $this->transactionCategory = $transactionCategory;

        return $this;
    }

    public function getCopies(): ?int
    {
        return $this->copies;
    }

    public function setCopies(int $copies): self
    {
        $this->copies = $copies;

        return $this;
    }
}
