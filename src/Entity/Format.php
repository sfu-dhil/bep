<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\FormatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Nines\UtilBundle\Entity\AbstractTerm;

#[ORM\Entity(repositoryClass: FormatRepository::class)]
class Format extends AbstractTerm {
    #[ORM\OneToMany(targetEntity: Book::class, mappedBy: 'format')]
    private Collection $books;

    public function __construct() {
        parent::__construct();
        $this->books = new ArrayCollection();
    }

    /**
     * @return Book[]|Collection
     */
    public function getBooks() : Collection {
        return $this->books;
    }

    public function addBook(Book $book) : self {
        if ( ! $this->books->contains($book)) {
            $this->books[] = $book;
            $book->setFormat($this);
        }

        return $this;
    }

    public function removeBook(Book $book) : self {
        if ($this->books->removeElement($book)) {
            // set the owning side to null (unless already changed)
            if ($book->getFormat() === $this) {
                $book->setFormat(null);
            }
        }

        return $this;
    }
}
