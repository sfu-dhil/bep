<?php

declare(strict_types=1);

/*
 * (c) 2020 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\DataFixtures;

use App\Entity\Transaction;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TransactionFixtures extends Fixture implements DependentFixtureInterface {
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $em) : void {
        for ($i = 1; $i <= 4; $i++) {
            $fixture = new Transaction();
            $fixture->setValue($i);
            $fixture->setShippingValue($i * 2);
            $fixture->setCopies($i);
            $fixture->setTranscription("<p>This is paragraph {$i}</p>");
            $fixture->setDescription("<p>This is paragraph {$i}</p>");
            $fixture->setBook($this->getReference('book.' . $i));
            $fixture->setParish($this->getReference('parish.' . $i));
            $fixture->setSource($this->getReference('source.' . $i));
            $fixture->setPage("p. {$i}");
            $fixture->setTransactioncategory($this->getReference('transactioncategory.' . $i));
            $fixture->setInjunction($this->getReference('injunction.' . $i));
            $em->persist($fixture);
            $this->setReference('transaction.' . $i, $fixture);
        }
        $em->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getDependencies() {
        return [
            BookFixtures::class,
            ParishFixtures::class,
            SourceFixtures::class,
            TransactionCategoryFixtures::class,
            InjunctionFixtures::class,
        ];
    }
}
