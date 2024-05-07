<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Archdeaconry;
use Doctrine\Persistence\ManagerRegistry;
use Nines\UtilBundle\Repository\TermRepository;

/**
 * @method null|Archdeaconry find($id, $lockMode = null, $lockVersion = null)
 * @method Archdeaconry[] findAll()
 * @method Archdeaconry[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method null|Archdeaconry findOneBy(array $criteria, array $orderBy = null)
 */
class ArchdeaconryRepository extends TermRepository {
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Archdeaconry::class);
    }
}
