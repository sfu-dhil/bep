<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\TransactionCategory;
use Doctrine\Persistence\ManagerRegistry;
use Nines\UtilBundle\Repository\TermRepository;

/**
 * @method null|TransactionCategory find($id, $lockMode = null, $lockVersion = null)
 * @method TransactionCategory[] findAll()
 * @method TransactionCategory[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method null|TransactionCategory findOneBy(array $criteria, array $orderBy = null)
 */
class TransactionCategoryRepository extends TermRepository {
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, TransactionCategory::class);
    }
}
