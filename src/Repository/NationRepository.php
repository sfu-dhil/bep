<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Nation;
use Doctrine\Persistence\ManagerRegistry;
use Nines\UtilBundle\Repository\TermRepository;

/**
 * @method null|Nation find($id, $lockMode = null, $lockVersion = null)
 * @method Nation[] findAll()
 * @method Nation[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method null|Nation findOneBy(array $criteria, array $orderBy = null)
 */
class NationRepository extends TermRepository {
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Nation::class);
    }
}
