<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Format;
use Doctrine\Persistence\ManagerRegistry;
use Nines\UtilBundle\Repository\TermRepository;

/**
 * @method null|Format find($id, $lockMode = null, $lockVersion = null)
 * @method Format[] findAll()
 * @method Format[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method null|Format findOneBy(array $criteria, array $orderBy = null)
 */
class FormatRepository extends TermRepository {
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Format::class);
    }
}
