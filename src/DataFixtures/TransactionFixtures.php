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
     * {@inheritdoc}
     */
    public function load(ObjectManager $em) : void {
        for ($i = 0; $i < 4; $i++) {
            $fixture = new Transaction();
            $fixture->setValue(200 * ($i + 1));
            $fixture->setTranscription("<p>Ye olde paragraf {$i} with ſongs.</p>");
            $fixture->setDescription("<p>This is paragraph {$i}</p>");
            $fixture->setCopies($i + 1);
            $fixture->setBook($this->getReference('book.' . $i));
            $fixture->setParish($this->getReference('parish.' . $i));
            $fixture->setTransactionCategory($this->getReference('transactioncategory.' . $i));
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
            TransactionCategoryFixtures::class,
        ];
    }
}
