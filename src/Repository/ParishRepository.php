<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Parish;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Parish|null find($id, $lockMode = null, $lockVersion = null)
 * @method Parish|null findOneBy(array $criteria, array $orderBy = null)
 * @method Parish[]    findAll()
 * @method Parish[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParishRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Parish::class);
    }

    /**
     * @return Query
     */
    public function indexQuery() {
        return $this->createQueryBuilder('parish')
            ->orderBy('parish.id')
            ->getQuery();
    }

    /**
     * @param string $q
     *
     * @return Collection|Parish[]
     */
    public function typeaheadQuery($q) {
        throw new \RuntimeException("Not implemented yet.");
        $qb = $this->createQueryBuilder('parish');
        $qb->andWhere('parish.column LIKE :q');
        $qb->orderBy('parish.column', 'ASC');
        $qb->setParameter('q', "{$q}%");

        return $qb->getQuery()->execute();
    }

    
}
