<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\SourceCategory;
use Doctrine\Persistence\ManagerRegistry;
use Nines\UtilBundle\Repository\TermRepository;

/**
 * @method null|SourceCategory find($id, $lockMode = null, $lockVersion = null)
 * @method SourceCategory[] findAll()
 * @method SourceCategory[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method null|SourceCategory findOneBy(array $criteria, array $orderBy = null)
 */
class SourceCategoryRepository extends TermRepository {
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, SourceCategory::class);
    }
}
