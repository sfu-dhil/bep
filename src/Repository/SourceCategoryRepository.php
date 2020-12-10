<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\SourceCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use Nines\UtilBundle\Repository\TermRepository;

/**
 * @method SourceCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method SourceCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method SourceCategory[]    findAll()
 * @method SourceCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SourceCategoryRepository extends TermRepository {
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, SourceCategory::class);
    }

}
