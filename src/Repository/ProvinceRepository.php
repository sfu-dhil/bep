<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Province;
use Doctrine\Persistence\ManagerRegistry;
use Nines\UtilBundle\Repository\TermRepository;

/**
 * @method null|Province find($id, $lockMode = null, $lockVersion = null)
 * @method Province[] findAll()
 * @method Province[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method null|Province findOneBy(array $criteria, array $orderBy = null)
 */
class ProvinceRepository extends TermRepository {
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Province::class);
    }
}
