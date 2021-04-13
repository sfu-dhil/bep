<?php

declare(strict_types=1);

/*
 * (c) 2020 Michael Joyce <mjoyce@sfu.ca>
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
 * @method null|Inventory findOneBy(array $criteria, array $orderBy = null)
 * @method Inventory[]    findAll()
 * @method Inventory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InventoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Inventory::class);
    }

    /**
     * @return Query
     */
    public function indexQuery() {
        return $this->createQueryBuilder('inventory')
            ->orderBy('inventory.id')
            ->getQuery()
        ;
    }
}
