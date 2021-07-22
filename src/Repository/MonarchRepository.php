<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Monarch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use Nines\UtilBundle\Repository\TermRepository;

/**
 * @method Monarch|null find($id, $lockMode = null, $lockVersion = null)
 * @method Monarch|null findOneBy(array $criteria, array $orderBy = null)
 * @method Monarch[]    findAll()
 * @method Monarch[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MonarchRepository extends TermRepository {
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Monarch::class);
    }
}
