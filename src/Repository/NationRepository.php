<?php

declare(strict_types=1);

/*
 * (c) 2021 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Repository;

use App\Entity\Nation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Nines\UtilBundle\Repository\TermRepository;

/**
 * @method null|Nation find($id, $lockMode = null, $lockVersion = null)
 * @method Nation[] findAll()
 * @method Nation[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method null|Nation findOneBy(array $criteria, array $orderBy = null)
 * @phpstan-extends ServiceEntityRepository<Nation>
 */
class NationRepository extends TermRepository {
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Nation::class);
    }
}
