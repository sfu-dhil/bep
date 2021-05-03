<?php

declare(strict_types=1);

/*
 * (c) 2020 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\DataFixtures;

use App\Entity\Holding;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class HoldingFixtures extends Fixture implements DependentFixtureInterface {
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $em) : void {
        for ($i = 1; $i <= 4; $i++) {
            $fixture = new Holding();
            $fixture->setDescription("<p>This is paragraph {$i}</p>");
            $fixture->setStartDate('1000-01-02');
            $fixture->setEndDate('1000-01-04');

            $fixture->setParish($this->getReference('parish.' . $i));
            $fixture->setBook($this->getReference('book.' . $i));
            $em->persist($fixture);
            $this->setReference('holding.' . $i, $fixture);
        }
        $em->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getDependencies() {
        return [
            ParishFixtures::class,
            BookFixtures::class,
        ];
    }
}
