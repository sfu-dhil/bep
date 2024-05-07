<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Parish;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Nines\MediaBundle\Entity\Link;

class ParishFixtures extends Fixture implements FixtureGroupInterface, DependentFixtureInterface {
    public static function getGroups() : array {
        return ['dev', 'test'];
    }

    public function load(ObjectManager $manager) : void {
        for ($i = 1; $i <= 5; $i++) {
            $fixture = new Parish();
            $fixture->setName('Name ' . $i);
            $fixture->setLabel('Label ' . $i);
            $fixture->setDescription("<p>This is paragraph {$i}</p>");
            $fixture->setLatitude((string) ($i + 0.5));
            $fixture->setLongitude((string) ($i + 0.5));
            $fixture->setAddress("<p>This is paragraph {$i}</p>");
            $fixture->setArchdeaconry($this->getReference('archdeaconry.' . $i));
            $fixture->setTown($this->getReference('town.' . $i));
            $manager->persist($fixture);
            $manager->flush();

            $link = new Link();
            $link->setText('Link ' . $i);
            $link->setUrl('https://example.com/path/to/' . $i);
            $fixture->addLink($link);
            $manager->persist($link);
            $manager->flush();

            $this->setReference('parish.' . $i, $fixture);
        }
    }

    public function getDependencies() : array {
        return [
            ArchdeaconryFixtures::class,
            TownFixtures::class,
        ];
    }
}
