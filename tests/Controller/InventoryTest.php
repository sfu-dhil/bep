<?php

declare(strict_types=1);

/*
 * (c) 2021 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Tests\Controller;

use Nines\MediaBundle\Repository\ImageRepository;
use Nines\MediaBundle\Service\ImageManager;
use Nines\UserBundle\DataFixtures\UserFixtures;
use Nines\UtilBundle\TestCase\ControllerTestCase;
use Symfony\Component\HttpFoundation\Response;

class InventoryTest extends ControllerTestCase {
    // Change this to HTTP_OK when the site is public.
    private const ANON_RESPONSE_CODE = Response::HTTP_FOUND;

    public function testAnonIndex() : void {
        $crawler = $this->client->request('GET', '/inventory/');
        $this->assertResponseStatusCodeSame(self::ANON_RESPONSE_CODE);
        $this->assertSame(0, $crawler->selectLink('New')->count());
    }

    public function testUserIndex() : void {
        $this->login(UserFixtures::USER);
        $crawler = $this->client->request('GET', '/inventory/');
        $this->assertResponseIsSuccessful();
        $this->assertSame(0, $crawler->selectLink('New')->count());
    }

    public function testAdminIndex() : void {
        $this->login(UserFixtures::ADMIN);
        $crawler = $this->client->request('GET', '/inventory/');
        $this->assertResponseIsSuccessful();
        $this->assertSame(1, $crawler->selectLink('New')->count());
    }

    public function testAnonShow() : void {
        $crawler = $this->client->request('GET', '/inventory/1');
        $this->assertResponseStatusCodeSame(self::ANON_RESPONSE_CODE);
        $this->assertSame(0, $crawler->selectLink('Edit')->count());
    }

    public function testUserShow() : void {
        $this->login(UserFixtures::USER);
        $crawler = $this->client->request('GET', '/inventory/1');
        $this->assertResponseIsSuccessful();
        $this->assertSame(0, $crawler->selectLink('Edit')->count());
    }

    public function testAdminShow() : void {
        $this->login(UserFixtures::ADMIN);
        $crawler = $this->client->request('GET', '/inventory/1');
        $this->assertResponseIsSuccessful();
        $this->assertSame(1, $crawler->selectLink('Edit')->count());
    }

    public function testAnonSearch() : void {
        $crawler = $this->client->request('GET', '/inventory/search');
        $this->assertResponseStatusCodeSame(self::ANON_RESPONSE_CODE);
        if (self::ANON_RESPONSE_CODE === Response::HTTP_FOUND) {
            // If authentication is required stop here.
            return;
        }

        $form = $crawler->selectButton('btn-search')->form([
            'q' => 'inventory',
        ]);

        $responseCrawler = $this->client->submit($form);
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
    }

    public function testUserSearch() : void {
        $this->login(UserFixtures::USER);
        $crawler = $this->client->request('GET', '/inventory/search');
        $this->assertResponseIsSuccessful();

        $form = $crawler->selectButton('btn-search')->form([
            'q' => 'inventory',
        ]);

        $responseCrawler = $this->client->submit($form);
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
    }

    public function testAdminSearch() : void {
        $this->login(UserFixtures::ADMIN);
        $crawler = $this->client->request('GET', '/inventory/search');
        $this->assertResponseIsSuccessful();

        $form = $crawler->selectButton('btn-search')->form([
            'q' => 'inventory',
        ]);

        $responseCrawler = $this->client->submit($form);
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
    }

    public function testAnonEdit() : void {
        $crawler = $this->client->request('GET', '/inventory/1/edit');
        $this->assertResponseRedirects('/login', Response::HTTP_FOUND);
    }

    public function testUserEdit() : void {
        $this->login(UserFixtures::USER);
        $crawler = $this->client->request('GET', '/inventory/1/edit');
        $this->assertSame(403, $this->client->getResponse()->getStatusCode());
    }

    public function testAdminEdit() : void {
        $this->login(UserFixtures::ADMIN);
        $formCrawler = $this->client->request('GET', '/inventory/1/edit');
        $this->assertResponseIsSuccessful();

        $form = $formCrawler->selectButton('Save')->form([
            'inventory[pageNumber]' => '<p>Updated Text</p>',
            'inventory[transcription]' => '<p>Updated Text</p>',
            'inventory[modifications]' => '<p>Updated Text</p>',
            'inventory[description]' => '<p>Updated Text</p>',
            'inventory[startDate]' => '1250-01-01',
            'inventory[endDate]' => '1258-11-08',
            'inventory[writtenDate]' => 'Updated WrittenDate',
            'inventory[notes]' => '<p>Updated Text</p>',
        ]);
        $this->overrideField($form, 'inventory[manuscriptSource]', 2);
        $this->overrideField($form, 'inventory[printSource]', 2);
        $this->overrideField($form, 'inventory[parish]', 2);
        $this->overrideField($form, 'inventory[monarch]', 2);

        $this->client->submit($form);
        $this->assertResponseRedirects('/inventory/1', Response::HTTP_FOUND);
        $responseCrawler = $this->client->followRedirect();
        $this->assertResponseIsSuccessful();
    }

    public function testAnonNew() : void {
        $crawler = $this->client->request('GET', '/inventory/new');
        $this->assertResponseRedirects('/login', Response::HTTP_FOUND);
    }

    public function testAnonNewPopup() : void {
        $crawler = $this->client->request('GET', '/inventory/new_popup');
        $this->assertResponseRedirects('/login', Response::HTTP_FOUND);
    }

    public function testUserNew() : void {
        $this->login(UserFixtures::USER);
        $crawler = $this->client->request('GET', '/inventory/new');
        $this->assertSame(403, $this->client->getResponse()->getStatusCode());
    }

    public function testUserNewPopup() : void {
        $this->login(UserFixtures::USER);
        $crawler = $this->client->request('GET', '/inventory/new_popup');
        $this->assertSame(403, $this->client->getResponse()->getStatusCode());
    }

    public function testAdminNew() : void {
        $this->login(UserFixtures::ADMIN);
        $formCrawler = $this->client->request('GET', '/inventory/new');
        $this->assertResponseIsSuccessful();

        $form = $formCrawler->selectButton('Save')->form([
            'inventory[pageNumber]' => '<p>Updated Text</p>',
            'inventory[transcription]' => '<p>Updated Text</p>',
            'inventory[modifications]' => '<p>Updated Text</p>',
            'inventory[description]' => '<p>Updated Text</p>',
            'inventory[startDate]' => '1258-11-08',
            'inventory[endDate]' => '1259-12-08',
            'inventory[writtenDate]' => 'Updated WrittenDate',
            'inventory[notes]' => '<p>Updated Text</p>',
        ]);
        $this->overrideField($form, 'inventory[manuscriptSource]', 2);
        $this->overrideField($form, 'inventory[printSource]', 2);
        $this->overrideField($form, 'inventory[parish]', 2);
        $this->overrideField($form, 'inventory[monarch]', 2);

        $this->client->submit($form);
        $this->assertResponseRedirects('/inventory/6', Response::HTTP_FOUND);
        $responseCrawler = $this->client->followRedirect();
        $this->assertResponseIsSuccessful();
    }

    public function testAdminNewPopup() : void {
        $this->login(UserFixtures::ADMIN);
        $formCrawler = $this->client->request('GET', '/inventory/new');
        $this->assertResponseIsSuccessful();

        $form = $formCrawler->selectButton('Save')->form([
            'inventory[pageNumber]' => '<p>Updated Text</p>',
            'inventory[transcription]' => '<p>Updated Text</p>',
            'inventory[modifications]' => '<p>Updated Text</p>',
            'inventory[description]' => '<p>Updated Text</p>',
            'inventory[startDate]' => '1258-11-08',
            'inventory[endDate]' => '1259-12-08',
            'inventory[writtenDate]' => 'Updated WrittenDate',
            'inventory[notes]' => '<p>Updated Text</p>',
        ]);
        $this->overrideField($form, 'inventory[manuscriptSource]', 2);
        $this->overrideField($form, 'inventory[printSource]', 2);
        $this->overrideField($form, 'inventory[parish]', 2);
        $this->overrideField($form, 'inventory[monarch]', 2);

        $this->client->submit($form);
        $this->assertResponseRedirects('/inventory/7', Response::HTTP_FOUND);
        $responseCrawler = $this->client->followRedirect();
        $this->assertResponseIsSuccessful();
    }

    public function testAnonNewImage() : void {
        $crawler = $this->client->request('GET', '/inventory/1/new_image');
        $this->assertResponseRedirects('/login', Response::HTTP_FOUND);
    }

    public function testUserNewImage() : void {
        $this->login(UserFixtures::USER);
        $crawler = $this->client->request('GET', '/inventory/1/new_image');
        $this->assertSame(403, $this->client->getResponse()->getStatusCode());
    }

    public function testAdminNewImage() : void {
        $this->login(UserFixtures::ADMIN);
        $crawler = $this->client->request('GET', '/inventory/1/new_image');
        $this->assertResponseIsSuccessful();

        $manager = self::$container->get(ImageManager::class);
        $manager->setCopy(true);

        $form = $crawler->selectButton('Create')->form([
            'image[public]' => 1,
            'image[description]' => 'Description',
            'image[license]' => 'License',
        ]);
        $form['image[file]']->upload(dirname(__FILE__, 2) . '/data/image/28213926366_4430448ff7_c.jpg');
        $this->client->submit($form);
        $this->assertResponseRedirects('/inventory/1');
        $responseCrawler = $this->client->followRedirect();
        $this->assertResponseIsSuccessful();

        $manager->setCopy(false);
    }

    public function testAnonEditImage() : void {
        $crawler = $this->client->request('GET', '/inventory/1/edit_image/1');
        $this->assertResponseRedirects('/login', Response::HTTP_FOUND);
    }

    public function testUserEditImage() : void {
        $this->login(UserFixtures::USER);
        $crawler = $this->client->request('GET', '/inventory/1/edit_image/1');
        $this->assertSame(403, $this->client->getResponse()->getStatusCode());
    }

    public function testAdminEditImage() : void {
        $this->login(UserFixtures::ADMIN);
        $crawler = $this->client->request('GET', '/inventory/1/edit_image/1');
        $this->assertResponseIsSuccessful();

        $manager = self::$container->get(ImageManager::class);
        $manager->setCopy(true);

        $form = $crawler->selectButton('Update')->form([
            'image[public]' => 0,
            'image[description]' => 'Updated Description',
            'image[license]' => 'Updated License',
        ]);
        $form['image[newFile]']->upload(dirname(__FILE__, 2) . '/data/image/3632486652_b432f7b283_c.jpg');
        $this->client->submit($form);
        $this->assertResponseRedirects('/inventory/1');
        $responseCrawler = $this->client->followRedirect();
        $this->assertResponseIsSuccessful();

        $manager->setCopy(false);
    }

    public function testAnonDeleteImage() : void {
        $crawler = $this->client->request('DELETE', '/inventory/1/delete_image/1');
        $this->assertResponseRedirects('/login', Response::HTTP_FOUND);
    }

    public function testUserDeleteImage() : void {
        $this->login(UserFixtures::USER);
        $crawler = $this->client->request('DELETE', '/inventory/1/delete_image/1');
        $this->assertSame(403, $this->client->getResponse()->getStatusCode());
    }

    public function testAdminDeleteImage() : void {
        $repo = self::$container->get(ImageRepository::class);
        $preCount = count($repo->findAll());

        $this->login(UserFixtures::ADMIN);
        $crawler = $this->client->request('GET', '/inventory/4');
        $this->assertResponseIsSuccessful();

        $form = $crawler->filter('form.delete-form[action="/inventory/4/delete_image/4"]')->form();
        $this->client->submit($form);
        $this->assertResponseRedirects('/inventory/4');
        $responseCrawler = $this->client->followRedirect();
        $this->assertResponseIsSuccessful();

        $this->em->clear();
        $postCount = count($repo->findAll());
        $this->assertSame($preCount - 1, $postCount);
    }

    public function testAdminDeleteWrongImage() : void {
        $repo = self::$container->get(ImageRepository::class);
        $preCount = count($repo->findAll());

        $this->login(UserFixtures::ADMIN);
        $crawler = $this->client->request('GET', '/inventory/4');
        $this->assertResponseIsSuccessful();

        $form = $crawler->filter('form.delete-form[action="/inventory/4/delete_image/4"]')->form();
        $form->getNode()->setAttribute('action', '/inventory/3/delete_image/4');

        $this->client->submit($form);
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);

        $this->em->clear();
        $postCount = count($repo->findAll());
        $this->assertSame($preCount, $postCount);
    }

    public function testAdminDeleteImageWrongToken() : void {
        $repo = self::$container->get(ImageRepository::class);
        $preCount = count($repo->findAll());

        $this->login(UserFixtures::ADMIN);
        $crawler = $this->client->request('GET', '/inventory/4');
        $this->assertResponseIsSuccessful();

        $form = $crawler->filter('form.delete-form[action="/inventory/4/delete_image/4"]')->form([
            '_token' => 'abc123',
        ]);

        $this->client->submit($form);
        $this->assertResponseRedirects('/inventory/4');
        $responseCrawler = $this->client->followRedirect();
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('div.alert-warning', 'Invalid security token.');

        $this->em->clear();
        $postCount = count($repo->findAll());
        $this->assertSame($preCount, $postCount);
    }
}
