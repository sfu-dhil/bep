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

class InventoryTest extends ControllerTestCase {
    // Change this to HTTP_OK when the site is public.
    private const ANON_RESPONSE_CODE = Response::HTTP_FOUND;

    private const TYPEAHEAD_QUERY = 'inventory';

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
        $form['inventory[source]']->disableValidation()->setValue(2);
        $form['inventory[parish]']->disableValidation()->setValue(2);
        $form['inventory[monarch]']->disableValidation()->setValue(2);

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
        $form['inventory[source]']->disableValidation()->setValue(2);
        $form['inventory[parish]']->disableValidation()->setValue(2);
        $form['inventory[monarch]']->disableValidation()->setValue(2);

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
        $form['inventory[source]']->disableValidation()->setValue(2);
        $form['inventory[parish]']->disableValidation()->setValue(2);
        $form['inventory[monarch]']->disableValidation()->setValue(2);

        $this->client->submit($form);
        $this->assertResponseRedirects('/inventory/7', Response::HTTP_FOUND);
        $responseCrawler = $this->client->followRedirect();
        $this->assertResponseIsSuccessful();
    }
}
