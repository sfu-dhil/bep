<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use Nines\MediaBundle\Repository\ImageRepository;
use Nines\MediaBundle\Service\ImageManager;
use Nines\UserBundle\DataFixtures\UserFixtures;
use Nines\UtilBundle\TestCase\ControllerTestCase;
use Symfony\Component\HttpFoundation\Response;

class HoldingTest extends ControllerTestCase {
    // Change this to HTTP_OK when the site is public.
    private const ANON_RESPONSE_CODE = Response::HTTP_FOUND;

    public function testAnonIndex() : void {
        $crawler = $this->client->request('GET', '/holding/');
        $this->assertResponseStatusCodeSame(self::ANON_RESPONSE_CODE);
        $this->assertSame(0, $crawler->filter('.page-actions')->selectLink('New')->count());
    }

    public function testUserIndex() : void {
        $this->login(UserFixtures::USER);
        $crawler = $this->client->request('GET', '/holding/');
        $this->assertResponseIsSuccessful();
        $this->assertSame(0, $crawler->filter('.page-actions')->selectLink('New')->count());
    }

    public function testAdminIndex() : void {
        $this->login(UserFixtures::ADMIN);
        $crawler = $this->client->request('GET', '/holding/');
        $this->assertResponseIsSuccessful();
        $this->assertSame(1, $crawler->filter('.page-actions')->selectLink('New')->count());
    }

    public function testAnonShow() : void {
        $crawler = $this->client->request('GET', '/holding/1');
        $this->assertResponseStatusCodeSame(self::ANON_RESPONSE_CODE);
        $this->assertSame(0, $crawler->filter('.page-actions')->selectLink('Edit')->count());
    }

    public function testUserShow() : void {
        $this->login(UserFixtures::USER);
        $crawler = $this->client->request('GET', '/holding/1');
        $this->assertResponseIsSuccessful();
        $this->assertSame(0, $crawler->filter('.page-actions')->selectLink('Edit')->count());
    }

    public function testAdminShow() : void {
        $this->login(UserFixtures::ADMIN);
        $crawler = $this->client->request('GET', '/holding/1');
        $this->assertResponseIsSuccessful();
        $this->assertSame(1, $crawler->filter('.page-actions')->selectLink('Edit')->count());
    }

    public function testAnonEdit() : void {
        $crawler = $this->client->request('GET', '/holding/1/edit');
        $this->assertResponseRedirects('http://localhost/login', Response::HTTP_FOUND);
    }

    public function testUserEdit() : void {
        $this->login(UserFixtures::USER);
        $crawler = $this->client->request('GET', '/holding/1/edit');
        $this->assertSame(Response::HTTP_FORBIDDEN, $this->client->getResponse()->getStatusCode(), $this->client->getResponse()->getContent());
    }

    public function testAdminEdit() : void {
        $this->login(UserFixtures::ADMIN);
        $formCrawler = $this->client->request('GET', '/holding/1/edit');
        $this->assertResponseIsSuccessful();

        $form = $formCrawler->selectButton('Save')->form([
            'holding[description]' => '<p>Updated Text</p>',
            'holding[startDate]' => '1200-01-01',
            'holding[endDate]' => '1250-12-25',
            'holding[writtenDate]' => 'Updated WrittenDate',
            'holding[notes]' => '<p>Updated Text</p>',
        ]);
        $this->overrideField($form, 'holding[parish]', '2');
        $this->overrideField($form, 'holding[archive]', '2');

        $this->client->submit($form);
        $this->assertResponseRedirects('/holding/1', Response::HTTP_FOUND);
        $responseCrawler = $this->client->followRedirect();
        $this->assertResponseIsSuccessful();
    }

    public function testAnonNew() : void {
        $crawler = $this->client->request('GET', '/holding/new');
        $this->assertResponseRedirects('http://localhost/login', Response::HTTP_FOUND);
    }

    public function testUserNew() : void {
        $this->login(UserFixtures::USER);
        $crawler = $this->client->request('GET', '/holding/new');
        $this->assertSame(Response::HTTP_FORBIDDEN, $this->client->getResponse()->getStatusCode(), $this->client->getResponse()->getContent());
    }

    public function testAdminNew() : void {
        $this->login(UserFixtures::ADMIN);
        $formCrawler = $this->client->request('GET', '/holding/new');
        $this->assertResponseIsSuccessful();

        $form = $formCrawler->selectButton('Save')->form([
            'holding[description]' => '<p>Updated Text</p>',
            'holding[startDate]' => '1200-01-01',
            'holding[endDate]' => '1250-12-25',
            'holding[writtenDate]' => 'Updated WrittenDate',
            'holding[notes]' => '<p>Updated Text</p>',
        ]);
        $this->overrideField($form, 'holding[parish]', '2');
        $this->overrideField($form, 'holding[archive]', '2');

        $this->client->submit($form);
        $this->assertResponseRedirects('/holding/6', Response::HTTP_FOUND);
        $responseCrawler = $this->client->followRedirect();
        $this->assertResponseIsSuccessful();
    }

    public function testAnonNewImage() : void {
        $crawler = $this->client->request('GET', '/holding/1/image/new');
        $this->assertResponseRedirects('http://localhost/login', Response::HTTP_FOUND);
    }

    public function testUserNewImage() : void {
        $this->login(UserFixtures::USER);
        $crawler = $this->client->request('GET', '/holding/1/image/new');
        $this->assertSame(Response::HTTP_FORBIDDEN, $this->client->getResponse()->getStatusCode(), $this->client->getResponse()->getContent());
    }

    public function testAdminNewImage() : void {
        $this->login(UserFixtures::ADMIN);
        $crawler = $this->client->request('GET', '/holding/1/image/new');
        $this->assertResponseIsSuccessful();

        $manager = self::getContainer()->get(ImageManager::class);
        $manager->setCopy(true);

        $form = $crawler->selectButton('Save')->form([
            'image[description]' => 'Description',
            'image[license]' => 'License',
        ]);
        $form['image[file]']->upload(dirname(__FILE__, 2) . '/data/image/28213926366_4430448ff7_c.jpg');
        $this->client->submit($form);
        $this->assertResponseRedirects('/holding/1');
        $responseCrawler = $this->client->followRedirect();
        $this->assertResponseIsSuccessful();

        $manager->setCopy(false);
    }

    public function testAnonEditImage() : void {
        $crawler = $this->client->request('GET', '/holding/1/image/11/edit');
        $this->assertResponseRedirects('http://localhost/login', Response::HTTP_FOUND);
    }

    public function testUserEditImage() : void {
        $this->login(UserFixtures::USER);
        $crawler = $this->client->request('GET', '/holding/1/image/11/edit');
        $this->assertSame(Response::HTTP_FORBIDDEN, $this->client->getResponse()->getStatusCode(), $this->client->getResponse()->getContent());
    }

    public function testAdminEditImage() : void {
        $this->login(UserFixtures::ADMIN);
        $crawler = $this->client->request('GET', '/holding/1/image/11/edit');
        $this->assertResponseIsSuccessful();

        $manager = self::getContainer()->get(ImageManager::class);
        $manager->setCopy(true);

        $form = $crawler->selectButton('Save')->form([
            'image[description]' => 'Updated Description',
            'image[license]' => 'Updated License',
        ]);
        $form['image[file]']->upload(dirname(__FILE__, 2) . '/data/image/3632486652_b432f7b283_c.jpg');
        $this->client->submit($form);
        $this->assertResponseRedirects('/holding/1');
        $responseCrawler = $this->client->followRedirect();
        $this->assertResponseIsSuccessful();

        $manager->setCopy(false);
    }

    public function testAnonDeleteImage() : void {
        $crawler = $this->client->request('DELETE', '/holding/1/image/11');
        $this->assertResponseRedirects('http://localhost/login', Response::HTTP_FOUND);
    }

    public function testUserDeleteImage() : void {
        $this->login(UserFixtures::USER);
        $crawler = $this->client->request('DELETE', '/holding/1/image/11');
        $this->assertSame(Response::HTTP_FORBIDDEN, $this->client->getResponse()->getStatusCode(), $this->client->getResponse()->getContent());
    }

    public function testAdminDeleteImage() : void {
        $repo = self::getContainer()->get(ImageRepository::class);
        $preCount = count($repo->findAll());

        $this->login(UserFixtures::ADMIN);
        $crawler = $this->client->request('GET', '/holding/4');
        $this->assertResponseIsSuccessful();

        $form = $crawler->filter('form[action="/holding/4/image/14"]')->form();
        $this->client->submit($form);
        $this->assertResponseRedirects('/holding/4');
        $responseCrawler = $this->client->followRedirect();
        $this->assertResponseIsSuccessful();

        $this->em->clear();
        $postCount = count($repo->findAll());
        $this->assertSame($preCount - 1, $postCount);
    }

    public function testAdminDeleteImageWrongToken() : void {
        $repo = self::getContainer()->get(ImageRepository::class);
        $preCount = count($repo->findAll());

        $this->login(UserFixtures::ADMIN);
        $crawler = $this->client->request('GET', '/holding/4');
        $this->assertResponseIsSuccessful();

        $form = $crawler->filter('form[action="/holding/4/image/14"]')->form([
            '_token' => 'abc123',
        ]);

        $this->client->submit($form);
        $this->assertResponseRedirects('/holding/4');
        $responseCrawler = $this->client->followRedirect();
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('div.alert-warning', 'Invalid security token.');

        $this->em->clear();
        $postCount = count($repo->findAll());
        $this->assertSame($preCount, $postCount);
    }
}
