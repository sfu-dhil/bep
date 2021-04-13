<?php

declare(strict_types=1);

/*
 * (c) 2020 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Repository;

use App\Entity\Parish;
use Doctrine\Persistence\ManagerRegistry;
use Nines\UtilBundle\Repository\TermRepository;

/**
 * @method null|Parish find($id, $lockMode = null, $lockVersion = null)
 * @method null|Parish findOneBy(array $criteria, array $orderBy = null)
 * @method Parish[]    findAll()
 * @method Parish[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParishRepository extends TermRepository
{
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Parish::class);
    }
}
