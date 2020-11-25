<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Archdeaconry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Archdeaconry|null find($id, $lockMode = null, $lockVersion = null)
 * @method Archdeaconry|null findOneBy(array $criteria, array $orderBy = null)
 * @method Archdeaconry[]    findAll()
 * @method Archdeaconry[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArchdeaconryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Archdeaconry::class);
    }

    /**
     * @return Query
     */
    public function indexQuery() {
        return $this->createQueryBuilder('archdeaconry')
            ->orderBy('archdeaconry.id')
            ->getQuery();
    }

    /**
     * @param string $q
     *
     * @return Collection|Archdeaconry[]
     */
    public function typeaheadQuery($q) {
        throw new \RuntimeException("Not implemented yet.");
        $qb = $this->createQueryBuilder('archdeaconry');
        $qb->andWhere('archdeaconry.column LIKE :q');
        $qb->orderBy('archdeaconry.column', 'ASC');
        $qb->setParameter('q', "{$q}%");

        return $qb->getQuery()->execute();
    }

    
}
