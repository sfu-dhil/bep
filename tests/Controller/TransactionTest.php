<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use Nines\UserBundle\DataFixtures\UserFixtures;
use Nines\UtilBundle\TestCase\ControllerTestCase;
use Symfony\Component\HttpFoundation\Response;

class TransactionTest extends ControllerTestCase {
    // Change this to HTTP_OK when the site is public.
    private const ANON_RESPONSE_CODE = Response::HTTP_FOUND;

    public function testAnonIndex() : void {
        $crawler = $this->client->request('GET', '/transaction/');
        $this->assertResponseStatusCodeSame(self::ANON_RESPONSE_CODE);
        $this->assertSame(0, $crawler->filter('.page-actions')->selectLink('New')->count());
    }

    public function testUserIndex() : void {
        $this->login(UserFixtures::USER);
        $crawler = $this->client->request('GET', '/transaction/');
        $this->assertResponseIsSuccessful();
        $this->assertSame(0, $crawler->filter('.page-actions')->selectLink('New')->count());
    }

    public function testAdminIndex() : void {
        $this->login(UserFixtures::ADMIN);
        $crawler = $this->client->request('GET', '/transaction/');
        $this->assertResponseIsSuccessful();
        $this->assertSame(1, $crawler->filter('.page-actions')->selectLink('New')->count());
    }

    public function testAnonShow() : void {
        $crawler = $this->client->request('GET', '/transaction/1');
        $this->assertResponseStatusCodeSame(self::ANON_RESPONSE_CODE);
        $this->assertSame(0, $crawler->filter('.page-actions')->selectLink('Edit')->count());
    }

    public function testUserShow() : void {
        $this->login(UserFixtures::USER);
        $crawler = $this->client->request('GET', '/transaction/1');
        $this->assertResponseIsSuccessful();
        $this->assertSame(0, $crawler->filter('.page-actions')->selectLink('Edit')->count());
    }

    public function testAdminShow() : void {
        $this->login(UserFixtures::ADMIN);
        $crawler = $this->client->request('GET', '/transaction/1');
        $this->assertResponseIsSuccessful();
        $this->assertSame(1, $crawler->filter('.page-actions')->selectLink('Edit')->count());
    }

    public function testAnonSearch() : void {
        $crawler = $this->client->request('GET', '/transaction/');
        $this->assertResponseStatusCodeSame(self::ANON_RESPONSE_CODE);
        if (self::ANON_RESPONSE_CODE === Response::HTTP_FOUND) {
            // If authentication is required stop here.
            return;
        }

        $form = $crawler->selectButton('btn-search')->form([
            'q' => 'transaction',
        ]);

        $responseCrawler = $this->client->submit($form);
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode(), $this->client->getResponse()->getContent());
    }

    public function testUserSearch() : void {
        $this->login(UserFixtures::USER);
        $crawler = $this->client->request('GET', '/transaction/');
        $this->assertResponseIsSuccessful();

        $form = $crawler->selectButton('btn-search')->form([
            'q' => 'transaction',
        ]);

        $responseCrawler = $this->client->submit($form);
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode(), $this->client->getResponse()->getContent());
    }

    public function testAdminSearch() : void {
        $this->login(UserFixtures::ADMIN);
        $crawler = $this->client->request('GET', '/transaction/');
        $this->assertResponseIsSuccessful();

        $form = $crawler->selectButton('btn-search')->form([
            'q' => 'transaction',
        ]);

        $responseCrawler = $this->client->submit($form);
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode(), $this->client->getResponse()->getContent());
    }

    public function testAnonEdit() : void {
        $crawler = $this->client->request('GET', '/transaction/1/edit');
        $this->assertResponseRedirects('http://localhost/login', Response::HTTP_FOUND);
    }

    public function testUserEdit() : void {
        $this->login(UserFixtures::USER);
        $crawler = $this->client->request('GET', '/transaction/1/edit');
        $this->assertSame(Response::HTTP_FORBIDDEN, $this->client->getResponse()->getStatusCode(), $this->client->getResponse()->getContent());
    }

    public function testAdminEdit() : void {
        $this->login(UserFixtures::ADMIN);
        $formCrawler = $this->client->request('GET', '/transaction/1/edit');
        $this->assertResponseIsSuccessful();

        $form = $formCrawler->selectButton('Save')->form([
            'transaction[l]' => 1,
            'transaction[s]' => 2,
            'transaction[d]' => 3,
            'transaction[sl]' => 1,
            'transaction[ss]' => 2,
            'transaction[sd]' => 3,
            'transaction[copies]' => 10,
            'transaction[location]' => 'Updated Location',
            'transaction[page]' => 'Updated Page',
            'transaction[transcription]' => '<p>Updated Text</p>',
            'transaction[modernTranscription]' => '<p>Updated Text</p>',
            'transaction[publicNotes]' => '<p>Updated Text</p>',
            'transaction[startDate]' => '1258-11-08',
            'transaction[endDate]' => '1259-12-08',
            'transaction[writtenDate]' => 'Updated WrittenDate',
            'transaction[notes]' => '<p>Updated Text</p>',
        ]);
        $this->overrideField($form, 'transaction[parish]', '2');
        $this->overrideField($form, 'transaction[manuscriptSource]', '2');
        $this->overrideField($form, 'transaction[printSource]', '2');
        $this->overrideField($form, 'transaction[injunction]', '2');
        $this->overrideField($form, 'transaction[monarch]', '2');

        $this->client->submit($form);
        $this->assertResponseRedirects('/transaction/1', Response::HTTP_FOUND);
        $responseCrawler = $this->client->followRedirect();
        $this->assertResponseIsSuccessful();
    }

    public function testAnonCopy() : void {
        $crawler = $this->client->request('GET', '/transaction/1/copy');
        $this->assertResponseRedirects('http://localhost/login', Response::HTTP_FOUND);
    }

    public function testUserCopy() : void {
        $this->login(UserFixtures::USER);
        $crawler = $this->client->request('GET', '/transaction/1/copy');
        $this->assertSame(Response::HTTP_FORBIDDEN, $this->client->getResponse()->getStatusCode(), $this->client->getResponse()->getContent());
    }

    public function testAdminCopy() : void {
        $this->login(UserFixtures::ADMIN);
        $formCrawler = $this->client->request('GET', '/transaction/1/copy');
        $this->assertResponseIsSuccessful();

        $form = $formCrawler->selectButton('Save')->form([
            'transaction[l]' => 1,
            'transaction[s]' => 2,
            'transaction[d]' => 3,
            'transaction[sl]' => 1,
            'transaction[ss]' => 2,
            'transaction[sd]' => 3,
            'transaction[copies]' => 10,
            'transaction[location]' => 'Updated Location',
            'transaction[page]' => 'Updated Page',
            'transaction[transcription]' => '<p>Updated Text</p>',
            'transaction[modernTranscription]' => '<p>Updated Text</p>',
            'transaction[publicNotes]' => '<p>Updated Text</p>',
            'transaction[startDate]' => '1258-11-08',
            'transaction[endDate]' => '1259-12-08',
            'transaction[writtenDate]' => 'Updated WrittenDate',
            'transaction[notes]' => '<p>Updated Text</p>',
        ]);
        $this->overrideField($form, 'transaction[parish]', '2');
        $this->overrideField($form, 'transaction[manuscriptSource]', '2');
        $this->overrideField($form, 'transaction[printSource]', '2');
        $this->overrideField($form, 'transaction[injunction]', '2');
        $this->overrideField($form, 'transaction[monarch]', '2');

        $this->client->submit($form);
        $this->assertResponseRedirects('/transaction/6', Response::HTTP_FOUND);
        $responseCrawler = $this->client->followRedirect();
        $this->assertResponseIsSuccessful();
    }

    public function testAnonNew() : void {
        $crawler = $this->client->request('GET', '/transaction/new');
        $this->assertResponseRedirects('http://localhost/login', Response::HTTP_FOUND);
    }

    public function testUserNew() : void {
        $this->login(UserFixtures::USER);
        $crawler = $this->client->request('GET', '/transaction/new');
        $this->assertSame(Response::HTTP_FORBIDDEN, $this->client->getResponse()->getStatusCode(), $this->client->getResponse()->getContent());
    }

    public function testAdminNew() : void {
        $this->login(UserFixtures::ADMIN);
        $formCrawler = $this->client->request('GET', '/transaction/new');
        $this->assertResponseIsSuccessful();

        $form = $formCrawler->selectButton('Save')->form([
            'transaction[l]' => 1,
            'transaction[s]' => 2,
            'transaction[d]' => 3,
            'transaction[sl]' => 1,
            'transaction[ss]' => 2,
            'transaction[sd]' => 3,
            'transaction[copies]' => 10,
            'transaction[location]' => 'Updated Location',
            'transaction[page]' => 'Updated Page',
            'transaction[transcription]' => '<p>Updated Text</p>',
            'transaction[modernTranscription]' => '<p>Updated Text</p>',
            'transaction[publicNotes]' => '<p>Updated Text</p>',
            'transaction[startDate]' => '1258-11-08',
            'transaction[endDate]' => '1259-12-08',
            'transaction[writtenDate]' => 'Updated WrittenDate',
            'transaction[notes]' => '<p>Updated Text</p>',
        ]);
        $this->overrideField($form, 'transaction[parish]', '2');
        $this->overrideField($form, 'transaction[manuscriptSource]', '2');
        $this->overrideField($form, 'transaction[printSource]', '2');
        $this->overrideField($form, 'transaction[injunction]', '2');
        $this->overrideField($form, 'transaction[monarch]', '2');

        $this->client->submit($form);
        $this->assertResponseRedirects('/transaction/7', Response::HTTP_FOUND);
        $responseCrawler = $this->client->followRedirect();
        $this->assertResponseIsSuccessful();
    }
}
