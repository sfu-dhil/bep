<?php

declare(strict_types=1);

/*
 * (c) 2022 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\DataFixtures;

use App\Entity\Transaction;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TransactionFixtures extends Fixture implements FixtureGroupInterface, DependentFixtureInterface {
    public static function getGroups() : array {
        return ['dev', 'test'];
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager) : void {
        for ($i = 1; $i <= 5; $i++) {
            $fixture = new Transaction();
            $fixture->setValue($i);
            $fixture->setShipping($i);
            $fixture->setCopies($i);
            $fixture->setLocation('Location ' . $i);
            $fixture->setPage('Page ' . $i);
            $fixture->setTranscription("<p>This is paragraph {$i}</p>");
            $fixture->setModernTranscription("<p>This is paragraph {$i}</p>");
            $fixture->setPublicNotes("<p>This is paragraph {$i}</p>");
            $fixture->setStartDate('1000-10-10');
            $fixture->setEndDate('1050-12-23');
            $fixture->setWrittenDate('WrittenDate ' . $i);
            $fixture->setNotes("<p>This is paragraph {$i}</p>");
            $fixture->setParish($this->getReference('parish.' . $i));
            $fixture->setManuscriptSource($this->getReference('manuscript_source.' . $i));
            $fixture->setInjunction($this->getReference('injunction.' . $i));
            $fixture->setMonarch($this->getReference('monarch.' . $i));
            $fixture->setPrintSource($this->getReference('print_source.' . $i));
            $manager->persist($fixture);
            $this->setReference('transaction.' . $i, $fixture);
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
            ParishFixtures::class,
            ManuscriptSourceFixtures::class,
            InjunctionFixtures::class,
            MonarchFixtures::class,
            PrintSourceFixtures::class,
        ];
    }
}
