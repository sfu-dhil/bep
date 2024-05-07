<?php

declare(strict_types=1);

namespace App\Tests\Repository;

use App\Repository\HoldingRepository;
use Nines\UtilBundle\TestCase\ServiceTestCase;

class HoldingRepositoryTest extends ServiceTestCase {
    private ?HoldingRepository $repo = null;

    public function testSetUp() : void {
        $this->assertInstanceOf(HoldingRepository::class, $this->repo);
    }

    public function testIndexQuery() : void {
        $query = $this->repo->indexQuery();
        $this->assertCount(5, $query->execute());
    }

    protected function setUp() : void {
        parent::setUp();
        $this->repo = self::getContainer()->get(HoldingRepository::class);
    }
}
