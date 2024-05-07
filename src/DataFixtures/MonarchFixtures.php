<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Monarch;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class MonarchFixtures extends Fixture implements FixtureGroupInterface {
    public static function getGroups() : array {
        return ['dev', 'test'];
    }

    public function load(ObjectManager $manager) : void {
        for ($i = 1; $i <= 5; $i++) {
            $fixture = new Monarch();
            $fixture->setName('Name ' . $i);
            $fixture->setLabel('Label ' . $i);
            $fixture->setDescription("<p>This is paragraph {$i}</p>");
            $fixture->setStartDate("10{$i}0-01-01");
            $fixture->setStartDate("10{$i}9-12-31");
            $manager->persist($fixture);
            $this->setReference('monarch.' . $i, $fixture);
        }
        $manager->flush();
    }
}
