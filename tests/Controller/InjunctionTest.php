<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use Nines\UserBundle\DataFixtures\UserFixtures;
use Nines\UtilBundle\TestCase\ControllerTestCase;
use Symfony\Component\HttpFoundation\Response;

class InjunctionTest extends ControllerTestCase {
    // Change this to HTTP_OK when the site is public.
    private const ANON_RESPONSE_CODE = Response::HTTP_FOUND;

    private const TYPEAHEAD_QUERY = 'title';

    public function testAnonIndex() : void {
        $crawler = $this->client->request('GET', '/injunction/');
        $this->assertResponseStatusCodeSame(self::ANON_RESPONSE_CODE);
        $this->assertSame(0, $crawler->filter('.page-actions')->selectLink('New')->count());
    }

    public function testUserIndex() : void {
        $this->login(UserFixtures::USER);
        $crawler = $this->client->request('GET', '/injunction/');
        $this->assertResponseIsSuccessful();
        $this->assertSame(0, $crawler->filter('.page-actions')->selectLink('New')->count());
    }

    public function testAdminIndex() : void {
        $this->login(UserFixtures::ADMIN);
        $crawler = $this->client->request('GET', '/injunction/');
        $this->assertResponseIsSuccessful();
        $this->assertSame(1, $crawler->filter('.page-actions')->selectLink('New')->count());
    }

    public function testAnonShow() : void {
        $crawler = $this->client->request('GET', '/injunction/1');
        $this->assertResponseStatusCodeSame(self::ANON_RESPONSE_CODE);
        $this->assertSame(0, $crawler->filter('.page-actions')->selectLink('Edit')->count());
    }

    public function testUserShow() : void {
        $this->login(UserFixtures::USER);
        $crawler = $this->client->request('GET', '/injunction/1');
        $this->assertResponseIsSuccessful();
        $this->assertSame(0, $crawler->filter('.page-actions')->selectLink('Edit')->count());
    }

    public function testAdminShow() : void {
        $this->login(UserFixtures::ADMIN);
        $crawler = $this->client->request('GET', '/injunction/1');
        $this->assertResponseIsSuccessful();
        $this->assertSame(1, $crawler->filter('.page-actions')->selectLink('Edit')->count());
    }

    public function testAnonTypeahead() : void {
        $this->client->request('GET', '/injunction/typeahead?q=' . self::TYPEAHEAD_QUERY);
        $response = $this->client->getResponse();
        $this->assertResponseStatusCodeSame(self::ANON_RESPONSE_CODE);
        if (self::ANON_RESPONSE_CODE === Response::HTTP_FOUND) {
            // If authentication is required stop here.
            return;
        }
        $this->assertSame('application/json', $response->headers->get('content-type'));
        $json = json_decode($response->getContent());
        $this->assertCount(5, $json);
    }

    public function testUserTypeahead() : void {
        $this->login(UserFixtures::USER);
        $this->client->request('GET', '/injunction/typeahead?q=' . self::TYPEAHEAD_QUERY);
        $response = $this->client->getResponse();
        $this->assertResponseIsSuccessful();
        $this->assertSame('application/json', $response->headers->get('content-type'));
        $json = json_decode($response->getContent());
        $this->assertCount(5, $json);
    }

    public function testAdminTypeahead() : void {
        $this->login(UserFixtures::ADMIN);
        $this->client->request('GET', '/injunction/typeahead?q=' . self::TYPEAHEAD_QUERY);
        $response = $this->client->getResponse();
        $this->assertResponseIsSuccessful();
        $this->assertSame('application/json', $response->headers->get('content-type'));
        $json = json_decode($response->getContent());
        $this->assertCount(5, $json);
    }

    public function testAnonSearch() : void {
        $crawler = $this->client->request('GET', '/injunction/');
        $this->assertResponseStatusCodeSame(self::ANON_RESPONSE_CODE);
        if (self::ANON_RESPONSE_CODE === Response::HTTP_FOUND) {
            // If authentication is required stop here.
            return;
        }

        $form = $crawler->selectButton('btn-search')->form([
            'q' => 'injunction',
        ]);

        $responseCrawler = $this->client->submit($form);
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode(), $this->client->getResponse()->getContent());
    }

    public function testUserSearch() : void {
        $this->login(UserFixtures::USER);
        $crawler = $this->client->request('GET', '/injunction/');
        $this->assertResponseIsSuccessful();

        $form = $crawler->selectButton('btn-search')->form([
            'q' => 'injunction',
        ]);

        $responseCrawler = $this->client->submit($form);
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode(), $this->client->getResponse()->getContent());
    }

    public function testAdminSearch() : void {
        $this->login(UserFixtures::ADMIN);
        $crawler = $this->client->request('GET', '/injunction/');
        $this->assertResponseIsSuccessful();

        $form = $crawler->selectButton('btn-search')->form([
            'q' => 'injunction',
        ]);

        $responseCrawler = $this->client->submit($form);
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode(), $this->client->getResponse()->getContent());
    }

    public function testAnonEdit() : void {
        $crawler = $this->client->request('GET', '/injunction/1/edit');
        $this->assertResponseRedirects('http://localhost/login', Response::HTTP_FOUND);
    }

    public function testUserEdit() : void {
        $this->login(UserFixtures::USER);
        $crawler = $this->client->request('GET', '/injunction/1/edit');
        $this->assertSame(Response::HTTP_FORBIDDEN, $this->client->getResponse()->getStatusCode(), $this->client->getResponse()->getContent());
    }

    public function testAdminEdit() : void {
        $this->login(UserFixtures::ADMIN);
        $formCrawler = $this->client->request('GET', '/injunction/1/edit');
        $this->assertResponseIsSuccessful();

        $form = $formCrawler->selectButton('Save')->form([
            'injunction[title]' => '<p>Updated Text</p>',
            'injunction[uniformTitle]' => '<p>Updated Text</p>',
            'injunction[author]' => 'Updated Author',
            'injunction[imprint]' => '<p>Updated Text</p>',
            'injunction[variantImprint]' => '<p>Updated Text</p>',
            'injunction[date]' => 'Updated Date',
            'injunction[physicalDescription]' => '<p>Updated Text</p>',
            'injunction[transcription]' => '<p>Updated Text</p>',
            'injunction[modernTranscription]' => '<p>Updated Text</p>',
            'injunction[estc]' => 'Updated Estc',
        ]);
        $this->overrideField($form, 'injunction[nation]', '2');
        $this->overrideField($form, 'injunction[diocese]', '2');
        $this->overrideField($form, 'injunction[province]', '2');
        $this->overrideField($form, 'injunction[archdeaconry]', '2');
        $this->overrideField($form, 'injunction[monarch]', '2');

        $this->client->submit($form);
        $this->assertResponseRedirects('/injunction/1', Response::HTTP_FOUND);
        $responseCrawler = $this->client->followRedirect();
        $this->assertResponseIsSuccessful();
    }

    public function testAnonNew() : void {
        $crawler = $this->client->request('GET', '/injunction/new');
        $this->assertResponseRedirects('http://localhost/login', Response::HTTP_FOUND);
    }

    public function testUserNew() : void {
        $this->login(UserFixtures::USER);
        $crawler = $this->client->request('GET', '/injunction/new');
        $this->assertSame(Response::HTTP_FORBIDDEN, $this->client->getResponse()->getStatusCode(), $this->client->getResponse()->getContent());
    }

    public function testAdminNew() : void {
        $this->login(UserFixtures::ADMIN);
        $formCrawler = $this->client->request('GET', '/injunction/new');
        $this->assertResponseIsSuccessful();

        $form = $formCrawler->selectButton('Save')->form([
            'injunction[title]' => '<p>Updated Text</p>',
            'injunction[uniformTitle]' => '<p>Updated Text</p>',
            'injunction[author]' => 'Updated Author',
            'injunction[imprint]' => '<p>Updated Text</p>',
            'injunction[variantImprint]' => '<p>Updated Text</p>',
            'injunction[date]' => 'Updated Date',
            'injunction[physicalDescription]' => '<p>Updated Text</p>',
            'injunction[transcription]' => '<p>Updated Text</p>',
            'injunction[modernTranscription]' => '<p>Updated Text</p>',
            'injunction[estc]' => 'Updated Estc',
        ]);
        $this->overrideField($form, 'injunction[nation]', '2');
        $this->overrideField($form, 'injunction[diocese]', '2');
        $this->overrideField($form, 'injunction[province]', '2');
        $this->overrideField($form, 'injunction[archdeaconry]', '2');
        $this->overrideField($form, 'injunction[monarch]', '2');

        $this->client->submit($form);
        $this->assertResponseRedirects('/injunction/6', Response::HTTP_FOUND);
        $responseCrawler = $this->client->followRedirect();
        $this->assertResponseIsSuccessful();
    }
}
