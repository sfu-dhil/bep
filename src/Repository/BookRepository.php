<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    /**
     * @return Query
     */
    public function indexQuery() {
        return $this->createQueryBuilder('book')
            ->orderBy('book.id')
            ->getQuery();
    }

    /**
     * @param string $q
     *
     * @return Collection|Book[]
     */
    public function typeaheadQuery($q) {
        throw new \RuntimeException("Not implemented yet.");
        $qb = $this->createQueryBuilder('book');
        $qb->andWhere('book.column LIKE :q');
        $qb->orderBy('book.column', 'ASC');
        $qb->setParameter('q', "{$q}%");

        return $qb->getQuery()->execute();
    }

    
}
