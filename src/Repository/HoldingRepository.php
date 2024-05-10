<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Holding;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method null|Holding find($id, $lockMode = null, $lockVersion = null)
 * @method Holding[] findAll()
 * @method Holding[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method null|Holding findOneBy(array $criteria, array $orderBy = null)
 *
 * @phpstan-extends ServiceEntityRepository<Holding>
 */
class HoldingRepository extends ServiceEntityRepository {
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Holding::class);
    }

    public function indexQuery() : Query {
        return $this->createQueryBuilder('holding')
            ->orderBy('holding.id')
            ->getQuery()
        ;
    }
}
