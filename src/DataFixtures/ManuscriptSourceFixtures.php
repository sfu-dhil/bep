<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\ManuscriptSource;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Nines\MediaBundle\Entity\Link;

class ManuscriptSourceFixtures extends Fixture implements FixtureGroupInterface, DependentFixtureInterface {
    public static function getGroups() : array {
        return ['dev', 'test'];
    }

    public function load(ObjectManager $manager) : void {
        for ($i = 1; $i <= 5; $i++) {
            $fixture = new ManuscriptSource();
            $fixture->setName('Name ' . $i);
            $fixture->setLabel('Label ' . $i);
            $fixture->setDescription("<p>This is paragraph {$i}</p>");
            $fixture->setCallNumber('CallNumber ' . $i);

            $fixture->setSourceCategory($this->getReference('source_category.' . $i));
            $fixture->setArchive($this->getReference('archive.' . $i));
            $manager->persist($fixture);
            $manager->flush();

            $link = new Link();
            $link->setText('Link ' . $i);
            $link->setUrl('https://example.com/path/to/' . $i);
            $fixture->addLink($link);
            $manager->persist($link);
            $manager->flush();

            $this->setReference('manuscript_source.' . $i, $fixture);
        }
    }

    public function getDependencies() : array {
        return [
            SourceCategoryFixtures::class,
            ArchiveFixtures::class,
        ];
    }
}
