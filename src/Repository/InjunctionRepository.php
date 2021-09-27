<?php

declare(strict_types=1);

/*
 * (c) 2021 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Repository;

use App\Entity\Injunction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method null|Injunction find($id, $lockMode = null, $lockVersion = null)
 * @method null|Injunction findOneBy(array $criteria, array $orderBy = null)
 * @method Injunction[] findAll()
 * @method Injunction[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InjunctionRepository extends ServiceEntityRepository {
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Injunction::class);
    }

    /**
     * @return Query
     */
    public function indexQuery() {
        return $this->createQueryBuilder('injunction')
            ->orderBy('injunction.title')
            ->getQuery()
        ;
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
     * @return Collection|Injunction[]|Query
     */
    public function searchQuery($q) {
        $qb = $this->createQueryBuilder('injunction');
        $qb->addSelect('MATCH (injunction.title, injunction.uniformTitle, injunction.variantTitles, injunction.description, injunction.author, injunction.imprint, injunction.variantImprint) AGAINST(:q BOOLEAN) as HIDDEN score');
        $qb->andHaving('score > 0');
        $qb->orderBy('score', 'DESC');
        $qb->setParameter('q', $q);

        return $qb->getQuery();
    }
}
