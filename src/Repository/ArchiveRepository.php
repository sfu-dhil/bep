<?php

declare(strict_types=1);

/*
 * (c) 2021 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Repository;

use App\Entity\Archive;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Nines\UtilBundle\Repository\TermRepository;

/**
 * @method null|Archive find($id, $lockMode = null, $lockVersion = null)
 * @method Archive[] findAll()
 * @method Archive[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method null|Archive findOneBy(array $criteria, array $orderBy = null)
 * @phpstan-extends ServiceEntityRepository<Archive>
 */
class ArchiveRepository extends TermRepository {
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Archive::class);
    }
}
