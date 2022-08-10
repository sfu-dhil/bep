<?php

declare(strict_types=1);

/*
 * (c) 2022 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\DataFixtures;

use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Nines\MediaBundle\Entity\Link;

class BookFixtures extends Fixture implements FixtureGroupInterface, DependentFixtureInterface {
    public static function getGroups() : array {
        return ['dev', 'test'];
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager) : void {
        for ($i = 1; $i <= 5; $i++) {
            $fixture = new Book();
            $fixture->setTitle("Title {$i}");
            $fixture->setUniformTitle("Uniform TItle {$i}");
            $fixture->setVariantTitles(['VariantTitles ' . $i]);
            $fixture->setAuthor('Author ' . $i);
            $fixture->setImprint("Imprint {$i}");
            $fixture->setVariantImprint("Variant Imprint {$i}");
            $fixture->setEstc('Estc ' . $i);
            $fixture->setDate('Date ' . $i);
            $fixture->setDescription("<p>This is paragraph {$i}</p>");
            $fixture->setPhysicalDescription("<p>This is paragraph {$i}</p>");
            $fixture->setNotes("<p>This is paragraph {$i}</p>");
            $fixture->setFormat($this->getReference('format.' . $i));
            $fixture->setMonarch($this->getReference('monarch.' . $i));
            $manager->persist($fixture);
            $manager->flush();

            $link = new Link();
            $link->setText('Link ' . $i);
            $link->setUrl('https://example.com/path/to/' . $i);
            $fixture->addLink($link);
            $manager->persist($link);
            $manager->flush();

            $this->setReference('book.' . $i, $fixture);
        }
    }

    /**
     * {@inheritdoc}
     *
     * @return array<string>
     */
    public function getDependencies() : array {
        return [
            FormatFixtures::class,
            MonarchFixtures::class,
        ];
    }
}
