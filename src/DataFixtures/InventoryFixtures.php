<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Inventory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Nines\MediaBundle\Entity\Image;
use Nines\MediaBundle\Service\ImageManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class InventoryFixtures extends Fixture implements FixtureGroupInterface, DependentFixtureInterface {
    public const IMAGE_FILES = [
        '28213926366_4430448ff7_c.jpg',
        '30191231240_4010f114ba_c.jpg',
        '33519978964_c025c0da71_c.jpg',
        '3632486652_b432f7b283_c.jpg',
        '49654941212_6e3bb28a75_c.jpg',
    ];

    private ?ImageManager $imageManager = null;

    public static function getGroups() : array {
        return ['dev', 'test'];
    }

    public function load(ObjectManager $manager) : void {
        $this->imageManager->setCopy(true);
        for ($i = 1; $i <= 5; $i++) {
            $fixture = new Inventory();
            $fixture->setPageNumber("Page {$i}");
            $fixture->setTranscription("<p>This is paragraph {$i}</p>");
            $fixture->setModifications("<p>This is paragraph {$i}</p>");
            $fixture->setDescription("<p>This is paragraph {$i}</p>");
            $fixture->setStartDate('1000-10-10');
            $fixture->setEndDate('1050-12-23');
            $fixture->setWrittenDate('WrittenDate ' . $i);
            $fixture->setNotes("<p>This is paragraph {$i}</p>");
            $fixture->setManuscriptSource($this->getReference('manuscript_source.' . $i));
            $fixture->setParish($this->getReference('parish.' . $i));
            $fixture->setMonarch($this->getReference('monarch.' . $i));
            $fixture->setPrintSource($this->getReference('print_source.' . $i));
            $manager->persist($fixture);
            $manager->flush();

            $imageFile = self::IMAGE_FILES[$i - 1];
            $upload = new UploadedFile(dirname(__FILE__, 3) . '/tests/data/image/' . $imageFile, $imageFile, 'image/jpeg', null, true);
            $image = new Image();
            $image->setFile($upload);
            $image->setOriginalName($imageFile);
            $image->setDescription("<p>This is paragraph {$i}</p>");
            $image->setLicense("<p>This is paragraph {$i}</p>");
            $image->setEntity($fixture);
            $manager->persist($image);

            $manager->flush();
            $this->setReference('inventory.' . $i, $fixture);
        }
        $this->imageManager->setCopy(false);
    }

    #[\Symfony\Contracts\Service\Attribute\Required]
    public function setImageManager(ImageManager $imageManager) : void {
        $this->imageManager = $imageManager;
    }

    public function getDependencies() : array {
        return [
            ManuscriptSourceFixtures::class,
            ParishFixtures::class,
            MonarchFixtures::class,
            PrintSourceFixtures::class,
        ];
    }
}
