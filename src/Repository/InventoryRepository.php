<?php

declare(strict_types=1);

/*
 * (c) 2021 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Repository;

use App\Entity\Inventory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method null|Inventory find($id, $lockMode = null, $lockVersion = null)
 * @method Inventory[] findAll()
 * @method Inventory[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method null|Inventory findOneBy(array $criteria, array $orderBy = null)
 * @phpstan-extends ServiceEntityRepository<Inventory>
 */
class InventoryRepository extends ServiceEntityRepository {
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Inventory::class);
    }

    public function indexQuery() : Query {
        return $this->createQueryBuilder('inventory')
            ->orderBy('inventory.id')
            ->getQuery()
        ;
    }

    public function searchQuery(string $q) : Query {
        $qb = $this->createQueryBuilder('inventory');
        $qb->addSelect('MATCH (inventory.transcription, inventory.modifications, inventory.description, inventory.notes) AGAINST(:q BOOLEAN) as HIDDEN score');
        $qb->andHaving('score > 0');
        $qb->orderBy('score', 'DESC');
        $qb->setParameter('q', $q);

        return $qb->getQuery();
    }
}
