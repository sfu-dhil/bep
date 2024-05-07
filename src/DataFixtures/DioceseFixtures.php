<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Diocese;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class DioceseFixtures extends Fixture implements FixtureGroupInterface, DependentFixtureInterface {
    public static function getGroups() : array {
        return ['dev', 'test'];
    }

    public function load(ObjectManager $manager) : void {
        for ($i = 1; $i <= 5; $i++) {
            $fixture = new Diocese();
            $fixture->setName('Name ' . $i);
            $fixture->setLabel('Label ' . $i);
            $fixture->setDescription("<p>This is paragraph {$i}</p>");
            $fixture->setProvince($this->getReference('province.' . $i));
            $manager->persist($fixture);
            $this->setReference('diocese.' . $i, $fixture);
        }
        $manager->flush();
    }

    public function getDependencies() : array {
        return [
            ProvinceFixtures::class,
        ];
    }
}
