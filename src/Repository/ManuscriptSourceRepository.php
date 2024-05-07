<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\ManuscriptSource;
use Doctrine\Persistence\ManagerRegistry;
use Nines\UtilBundle\Repository\TermRepository;

/**
 * @method null|ManuscriptSource find($id, $lockMode = null, $lockVersion = null)
 * @method ManuscriptSource[] findAll()
 * @method ManuscriptSource[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method null|ManuscriptSource findOneBy(array $criteria, array $orderBy = null)
 */
class ManuscriptSourceRepository extends TermRepository {
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, ManuscriptSource::class);
    }
}
