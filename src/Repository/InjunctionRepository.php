<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Injunction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Injunction|null find($id, $lockMode = null, $lockVersion = null)
 * @method Injunction|null findOneBy(array $criteria, array $orderBy = null)
 * @method Injunction[]    findAll()
 * @method Injunction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InjunctionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Injunction::class);
    }

    /**
     * @return Query
     */
    public function indexQuery() {
        return $this->createQueryBuilder('injunction')
            ->orderBy('injunction.title')
            ->getQuery();
    }

    /**
     * @param string $q
     *
     * @return Collection|Injunction[]
     */
    public function typeaheadQuery($q) {
        $qb = $this->createQueryBuilder('injunction');
        $qb->andWhere('injunction.title LIKE :q');
        $qb->orderBy('injunction.title', 'ASC');
        $qb->setParameter('q', "{$q}%");

        return $qb->getQuery()->execute();
    }

    /**
     * @param string $q
     *
     * @return Collection|Injunction[]
     */
    public function searchQuery($q) {
        $qb = $this->createQueryBuilder('injunction');
        $qb->andWhere('injunction.title LIKE :q');
        $qb->orderBy('injunction.title', 'ASC');
        $qb->setParameter('q', "{$q}%");

        return $qb->getQuery()->execute();
    }

}
