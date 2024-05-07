<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Town;
use Doctrine\Persistence\ManagerRegistry;
use Nines\UtilBundle\Repository\TermRepository;

/**
 * @method null|Town find($id, $lockMode = null, $lockVersion = null)
 * @method Town[] findAll()
 * @method Town[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method null|Town findOneBy(array $criteria, array $orderBy = null)
 */
class TownRepository extends TermRepository {
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Town::class);
    }
}
