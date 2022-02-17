<?php

declare(strict_types=1);

/*
 * (c) 2021 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Tests\Repository;

use App\Repository\HoldingRepository;
use Nines\UtilBundle\TestCase\ServiceTestCase;

class HoldingRepositoryTest extends ServiceTestCase {
    private HoldingRepository $repo;

    public function testSetUp() : void {
        $this->assertInstanceOf(HoldingRepository::class, $this->repo);
    }

    public function testIndexQuery() : void {
        $query = $this->repo->indexQuery();
        $this->assertCount(5, $query->execute());
    }

    protected function setUp() : void {
        parent::setUp();
        $this->repo = self::$container->get(HoldingRepository::class);
    }
}
