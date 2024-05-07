<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\PrintSource;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method null|PrintSource find($id, $lockMode = null, $lockVersion = null)
 * @method PrintSource[] findAll()
 * @method PrintSource[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method null|PrintSource findOneBy(array $criteria, array $orderBy = null)
 *
 * @phpstan-extends ServiceEntityRepository<PrintSource>
 */
class PrintSourceRepository extends ServiceEntityRepository {
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, PrintSource::class);
    }

    public function indexQuery() : Query {
        return $this->createQueryBuilder('printSource')
            ->orderBy('printSource.id')
            ->getQuery()
        ;
    }

    public function typeaheadQuery(string $q) : Query {
        $qb = $this->createQueryBuilder('printSource');
        $qb->andWhere('printSource.title LIKE :q');
        $qb->orderBy('printSource.title', 'ASC');
        $qb->setParameter('q', "{$q}%");

        return $qb->getQuery();
    }

    public function searchQuery(string $q) : Query {
        $qb = $this->createQueryBuilder('printSource');
        $qb->addSelect('MATCH (printSource.title, printSource.author, printSource.publisher) AGAINST(:q BOOLEAN) as HIDDEN score');
        $qb->andHaving('score > 0');
        $qb->orderBy('score', 'DESC');
        $qb->setParameter('q', $q);

        return $qb->getQuery();
    }
}
