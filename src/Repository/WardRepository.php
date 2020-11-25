<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Ward;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Ward|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ward|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ward[]    findAll()
 * @method Ward[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WardRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ward::class);
    }

    /**
     * @return Query
     */
    public function indexQuery() {
        return $this->createQueryBuilder('ward')
            ->orderBy('ward.id')
            ->getQuery();
    }

    /**
     * @param string $q
     *
     * @return Collection|Ward[]
     */
    public function typeaheadQuery($q) {
        throw new \RuntimeException("Not implemented yet.");
        $qb = $this->createQueryBuilder('ward');
        $qb->andWhere('ward.column LIKE :q');
        $qb->orderBy('ward.column', 'ASC');
        $qb->setParameter('q', "{$q}%");

        return $qb->getQuery()->execute();
    }

    
}
