<?php

declare(strict_types=1);

/*
 * (c) 2021 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Repository;

use App\Entity\Transaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use RuntimeException;

/**
 * @method null|Transaction find($id, $lockMode = null, $lockVersion = null)
 * @method null|Transaction findOneBy(array $criteria, array $orderBy = null)
 * @method Transaction[] findAll()
 * @method Transaction[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TransactionRepository extends ServiceEntityRepository {
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Transaction::class);
    }

    /**
     * @return Query
     */
    public function indexQuery() {
        return $this->createQueryBuilder('transaction')
            ->orderBy('transaction.startDate')
            ->addOrderBy('transaction.endDate')
            ->addOrderBy('transaction.id')
            ->getQuery()
        ;
    }

    /**
     * @param string $q
     *
     * @return Collection|Query|Transaction[]
     */
    public function searchQuery($q) {
        $qb = $this->createQueryBuilder('transaction');
        $qb->addSelect('MATCH (transaction.transcription, transaction.description, transaction.notes) AGAINST(:q BOOLEAN) as HIDDEN score');
        $qb->andHaving('score > 0');
        $qb->orderBy('score', 'DESC');
        $qb->setParameter('q', $q);

        return $qb->getQuery();
    }

}
