<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Monarch;
use Doctrine\Persistence\ManagerRegistry;
use Nines\UtilBundle\Repository\TermRepository;

/**
 * @method null|Monarch find($id, $lockMode = null, $lockVersion = null)
 * @method Monarch[] findAll()
 * @method Monarch[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method null|Monarch findOneBy(array $criteria, array $orderBy = null)
 */
class MonarchRepository extends TermRepository {
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Monarch::class);
    }
}
