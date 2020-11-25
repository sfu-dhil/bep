<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Transaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Transaction|null find($id, $lockMode = null, $lockVersion = null)
 * @method Transaction|null findOneBy(array $criteria, array $orderBy = null)
 * @method Transaction[]    findAll()
 * @method Transaction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TransactionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Transaction::class);
    }

    /**
     * @return Query
     */
    public function indexQuery() {
        return $this->createQueryBuilder('transaction')
            ->orderBy('transaction.id')
            ->getQuery();
    }

    /**
     * @param string $q
     *
     * @return Collection|Transaction[]
     */
    public function typeaheadQuery($q) {
        throw new \RuntimeException("Not implemented yet.");
        $qb = $this->createQueryBuilder('transaction');
        $qb->andWhere('transaction.column LIKE :q');
        $qb->orderBy('transaction.column', 'ASC');
        $qb->setParameter('q', "{$q}%");

        return $qb->getQuery()->execute();
    }

    
}
