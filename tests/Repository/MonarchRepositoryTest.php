<?php

declare(strict_types=1);

namespace App\Tests\Repository;

use App\Repository\MonarchRepository;
use Nines\UtilBundle\TestCase\ServiceTestCase;

class MonarchRepositoryTest extends ServiceTestCase {
    private const TYPEAHEAD_QUERY = 'label';

    private ?MonarchRepository $repo = null;

    public function testSetUp() : void {
        $this->assertInstanceOf(MonarchRepository::class, $this->repo);
    }

    public function testIndexQuery() : void {
        $query = $this->repo->indexQuery();
        $this->assertCount(5, $query->execute());
    }

    public function testTypeaheadQuery() : void {
        $query = $this->repo->typeaheadQuery(self::TYPEAHEAD_QUERY);
        $this->assertCount(5, $query->execute());
    }

    public function testSearchQuery() : void {
        $query = $this->repo->searchQuery(self::TYPEAHEAD_QUERY);
        $this->assertCount(5, $query->execute());
    }

    protected function setUp() : void {
        parent::setUp();
        $this->repo = self::getContainer()->get(MonarchRepository::class);
    }
}
