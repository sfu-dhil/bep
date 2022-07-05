<?php

declare(strict_types=1);

/*
 * (c) 2021 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\DataFixtures;

use App\Entity\Injunction;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class InjunctionFixtures extends Fixture implements FixtureGroupInterface, DependentFixtureInterface {
    public static function getGroups() : array {
        return ['dev', 'test'];
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager) : void {
        for ($i = 1; $i <= 5; $i++) {
            $fixture = new Injunction();
            $fixture->setTitle("Title {$i}");
            $fixture->setUniformTitle("Uniform TItle {$i}");
            $fixture->setVariantTitles(['VariantTitles ' . $i]);
            $fixture->setAuthor('Author ' . $i);
            $fixture->setImprint("<p>This is paragraph {$i}</p>");
            $fixture->setVariantImprint("<p>This is paragraph {$i}</p>");
            $fixture->setDate('Date ' . $i);
            $fixture->setPhysicalDescription("<p>This is paragraph {$i}</p>");
            $fixture->setTranscription("<p>This is paragraph {$i}</p>");
            $fixture->setModernTranscription("<p>This is paragraph {$i}</p>");
            $fixture->setEstc('Estc ' . $i);

            $fixture->setMonarch($this->getReference('monarch.' . $i));

            $manager->persist($fixture);
            $this->setReference('injunction.' . $i, $fixture);
        }
        $manager->flush();
    }

    /**
     * {@inheritdoc}
     *
     * @return array<string>
     */
    public function getDependencies() : array {
        return [
            MonarchFixtures::class,
        ];
    }
}
