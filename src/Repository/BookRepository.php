<?php

declare(strict_types=1);

/*
 * (c) 2022 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method null|Book find($id, $lockMode = null, $lockVersion = null)
 * @method Book[] findAll()
 * @method Book[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method null|Book findOneBy(array $criteria, array $orderBy = null)
 * @phpstan-extends ServiceEntityRepository<Book>
 */
class BookRepository extends ServiceEntityRepository {
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Book::class);
    }

    public function indexQuery() : Query {
        return $this->createQueryBuilder('book')
            ->orderBy('book.title')
            ->addOrderBy('book.id')
            ->getQuery()
        ;
    }

    public function typeaheadQuery(string $q) : Query {
        $qb = $this->createQueryBuilder('book');
        $qb->where('book.title LIKE :q');
        $qb->orWhere('book.variantTitles LIKE :q');
        $qb->orderBy('book.title');
        $qb->addOrderBy('book.id');
        $qb->setParameter('q', "%{$q}%");

        return $qb->getQuery();
    }

    public function searchQuery(string $q) : Query {
        $qb = $this->createQueryBuilder('book');
        $qb->addSelect('MATCH (book.title, book.uniformTitle, book.variantTitles, book.description, book.author, book.imprint, book.variantImprint, book.notes) AGAINST(:q BOOLEAN) as HIDDEN score');
        $qb->andHaving('score > 0');
        $qb->orderBy('score', 'DESC');
        $qb->setParameter('q', $q);

        return $qb->getQuery();
    }
}
