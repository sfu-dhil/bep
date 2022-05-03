<?php

declare(strict_types=1);

/*
 * (c) 2021 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Repository;

use App\Entity\County;
use Doctrine\Persistence\ManagerRegistry;
use Nines\UtilBundle\Repository\TermRepository;

/**
 * @method null|County find($id, $lockMode = null, $lockVersion = null)
 * @method County[] findAll()
 * @method County[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method null|County findOneBy(array $criteria, array $orderBy = null)
 */
class CountyRepository extends TermRepository {
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, County::class);
    }
}
