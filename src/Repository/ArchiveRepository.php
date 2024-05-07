<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Archive;
use Doctrine\Persistence\ManagerRegistry;
use Nines\UtilBundle\Repository\TermRepository;

/**
 * @method null|Archive find($id, $lockMode = null, $lockVersion = null)
 * @method Archive[] findAll()
 * @method Archive[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method null|Archive findOneBy(array $criteria, array $orderBy = null)
 */
class ArchiveRepository extends TermRepository {
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Archive::class);
    }
}
