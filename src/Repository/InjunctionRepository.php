<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Injunction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method null|Injunction find($id, $lockMode = null, $lockVersion = null)
 * @method Injunction[] findAll()
 * @method Injunction[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method null|Injunction findOneBy(array $criteria, array $orderBy = null)
 *
 * @phpstan-extends ServiceEntityRepository<Injunction>
 */
class InjunctionRepository extends ServiceEntityRepository {
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Injunction::class);
    }

    public function indexQuery() : Query {
        return $this->createQueryBuilder('injunction')
            ->orderBy('injunction.title')
            ->getQuery()
        ;
    }

    public function typeaheadQuery(string $q) : Query {
        $qb = $this->createQueryBuilder('injunction');
        $qb->andWhere('injunction.title LIKE :q');
        $qb->orderBy('injunction.title', 'ASC');
        $qb->setParameter('q', "{$q}%");

        return $qb->getQuery();
    }

    public function searchQuery(string $q) : Query {
        $qb = $this->createQueryBuilder('injunction');
        $qb->addSelect('MATCH (injunction.title, injunction.uniformTitle, injunction.variantTitles, injunction.transcription, injunction.modernTranscription, injunction.author, injunction.imprint, injunction.variantImprint) AGAINST(:q BOOLEAN) as HIDDEN score');
        $qb->andHaving('score > 0');
        $qb->orderBy('score', 'DESC');
        $qb->setParameter('q', $q);

        return $qb->getQuery();
    }
}
