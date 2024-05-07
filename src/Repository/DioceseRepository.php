<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Diocese;
use Doctrine\Persistence\ManagerRegistry;
use Nines\UtilBundle\Repository\TermRepository;

/**
 * @method null|Diocese find($id, $lockMode = null, $lockVersion = null)
 * @method Diocese[] findAll()
 * @method Diocese[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method null|Diocese findOneBy(array $criteria, array $orderBy = null)
 */
class DioceseRepository extends TermRepository {
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Diocese::class);
    }
}
