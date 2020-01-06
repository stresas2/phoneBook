<?php


namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;


class GuestNotAvailableUrTest extends WebTestCase
{
    private $client;

    /**
     * @dataProvider provideUrls
     */
    public function testUrl($url)
    {
        $this->client = static::createClient();

        $this->client->request('GET', $url);

        $this->assertNotSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }


    public function provideUrls()
    {
        return [
            ['/list'],
            ['/contact/new'],
            ['/request'],
        ];
    }
}