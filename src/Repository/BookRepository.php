<?php

declare(strict_types=1);

/*
 * (c) 2021 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method null|Book find($id, $lockMode = null, $lockVersion = null)
 * @method null|Book findOneBy(array $criteria, array $orderBy = null)
 * @method Book[] findAll()
 * @method Book[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository {
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Book::class);
    }

    /**
     * @return Query
     */
    public function indexQuery() {
        $qb = $this->createQueryBuilder('book');
        $qb->orderBy('book.title');
        $qb->addOrderBy('book.id');

        return $qb->getQuery();
    }

    /**
     * @param string $q
     *
     * @return Book[]|Collection
     */
    public function typeaheadQuery($q) {
        $qb = $this->createQueryBuilder('book');
        $qb->andWhere('book.title LIKE :q');
        $qb->orderBy('book.title');
        $qb->addOrderBy('book.id');
        $qb->setParameter('q', "{$q}%");

        return $qb->getQuery()->execute();
    }

    /**
     * @param string $q
     *
     * @return Book[]|Collection
     */
    public function searchQuery($q) {
        $qb = $this->createQueryBuilder('book');
        $qb->where('book.title LIKE :q');
        $qb->orWhere('book.description LIKE :q');
        $qb->orderBy('book.title');
        $qb->addOrderBy('book.id');
        $qb->setParameter('q', "%{$q}%");

        return $qb->getQuery()->execute();
    }
}
