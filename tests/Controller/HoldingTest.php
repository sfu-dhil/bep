<?php

declare(strict_types=1);

/*
 * (c) 2021 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Tests\Controller;

use Nines\UserBundle\DataFixtures\UserFixtures;
use Nines\UtilBundle\TestCase\ControllerTestCase;
use Symfony\Component\HttpFoundation\Response;

class HoldingTest extends ControllerTestCase {
    // Change this to HTTP_OK when the site is public.
    private const ANON_RESPONSE_CODE = Response::HTTP_FOUND;

    public function testAnonIndex() : void {
        $crawler = $this->client->request('GET', '/holding/');
        $this->assertResponseStatusCodeSame(self::ANON_RESPONSE_CODE);
        $this->assertSame(0, $crawler->selectLink('New')->count());
    }

    public function testUserIndex() : void {
        $this->login(UserFixtures::USER);
        $crawler = $this->client->request('GET', '/holding/');
        $this->assertResponseIsSuccessful();
        $this->assertSame(0, $crawler->selectLink('New')->count());
    }

    public function testAdminIndex() : void {
        $this->login(UserFixtures::ADMIN);
        $crawler = $this->client->request('GET', '/holding/');
        $this->assertResponseIsSuccessful();
        $this->assertSame(1, $crawler->selectLink('New')->count());
    }

    public function testAnonShow() : void {
        $crawler = $this->client->request('GET', '/holding/1');
        $this->assertResponseStatusCodeSame(self::ANON_RESPONSE_CODE);
        $this->assertSame(0, $crawler->selectLink('Edit')->count());
    }

    public function testUserShow() : void {
        $this->login(UserFixtures::USER);
        $crawler = $this->client->request('GET', '/holding/1');
        $this->assertResponseIsSuccessful();
        $this->assertSame(0, $crawler->selectLink('Edit')->count());
    }

    public function testAdminShow() : void {
        $this->login(UserFixtures::ADMIN);
        $crawler = $this->client->request('GET', '/holding/1');
        $this->assertResponseIsSuccessful();
        $this->assertSame(1, $crawler->selectLink('Edit')->count());
    }

    public function testAnonSearch() : void {
        $crawler = $this->client->request('GET', '/holding/search');
        $this->assertResponseStatusCodeSame(self::ANON_RESPONSE_CODE);
        if (self::ANON_RESPONSE_CODE === Response::HTTP_FOUND) {
            // If authentication is required stop here.
            return;
        }

        $form = $crawler->selectButton('btn-search')->form([
            'q' => 'holding',
        ]);

        $responseCrawler = $this->client->submit($form);
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
    }

    public function testAnonEdit() : void {
        $crawler = $this->client->request('GET', '/holding/1/edit');
        $this->assertResponseRedirects('/login', Response::HTTP_FOUND);
    }

    public function testUserEdit() : void {
        $this->login(UserFixtures::USER);
        $crawler = $this->client->request('GET', '/holding/1/edit');
        $this->assertSame(403, $this->client->getResponse()->getStatusCode());
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
        $form['holding[parish]']->disableValidation()->setValue(2);
        $form['holding[archive]']->disableValidation()->setValue(2);

        $this->client->submit($form);
        $this->assertResponseRedirects('/holding/1', Response::HTTP_FOUND);
        $responseCrawler = $this->client->followRedirect();
        $this->assertResponseIsSuccessful();
    }

    public function testAnonNew() : void {
        $crawler = $this->client->request('GET', '/holding/new');
        $this->assertResponseRedirects('/login', Response::HTTP_FOUND);
    }

    public function testAnonNewPopup() : void {
        $crawler = $this->client->request('GET', '/holding/new_popup');
        $this->assertResponseRedirects('/login', Response::HTTP_FOUND);
    }

    public function testUserNew() : void {
        $this->login(UserFixtures::USER);
        $crawler = $this->client->request('GET', '/holding/new');
        $this->assertSame(403, $this->client->getResponse()->getStatusCode());
    }

    public function testUserNewPopup() : void {
        $this->login(UserFixtures::USER);
        $crawler = $this->client->request('GET', '/holding/new_popup');
        $this->assertSame(403, $this->client->getResponse()->getStatusCode());
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
        $form['holding[parish]']->disableValidation()->setValue(2);
        $form['holding[archive]']->disableValidation()->setValue(2);

        $this->client->submit($form);
        $this->assertResponseRedirects('/holding/6', Response::HTTP_FOUND);
        $responseCrawler = $this->client->followRedirect();
        $this->assertResponseIsSuccessful();
    }

    public function testAdminNewPopup() : void {
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
        $form['holding[parish]']->disableValidation()->setValue(2);
        $form['holding[archive]']->disableValidation()->setValue(2);

        $this->client->submit($form);
        $this->assertResponseRedirects('/holding/7', Response::HTTP_FOUND);
        $responseCrawler = $this->client->followRedirect();
        $this->assertResponseIsSuccessful();
    }
}
