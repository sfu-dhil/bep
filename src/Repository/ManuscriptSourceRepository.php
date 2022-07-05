<?php

declare(strict_types=1);

/*
 * (c) 2022 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

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
