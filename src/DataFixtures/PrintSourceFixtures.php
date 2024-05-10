<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\PrintSource;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Nines\MediaBundle\Entity\Link;

class PrintSourceFixtures extends Fixture implements FixtureGroupInterface, DependentFixtureInterface {
    public static function getGroups() : array {
        return ['dev', 'test'];
    }

    public function load(ObjectManager $manager) : void {
        for ($i = 1; $i <= 5; $i++) {
            $fixture = new PrintSource();
            $fixture->setTitle('Title ' . $i);
            $fixture->setAuthor('Author ' . $i);
            $fixture->setDate('Date ' . $i);
            $fixture->setPublisher('Publisher ' . $i);
            $fixture->setNotes("<p>This is paragraph {$i}</p>");
            $fixture->setSourcecategory($this->getReference('source_category.' . $i));
            $manager->persist($fixture);
            $manager->flush();

            $link = new Link();
            $link->setText('Link ' . $i);
            $link->setUrl('https://example.com/path/to/' . $i);
            $fixture->addLink($link);
            $manager->persist($link);
            $manager->flush();

            $this->setReference('print_source.' . $i, $fixture);
        }
        $manager->flush();
    }

    public function getDependencies() : array {
        return [
            SourceCategoryFixtures::class,
        ];
    }
}
