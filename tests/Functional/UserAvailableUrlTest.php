<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class UserAvailableUrlTest extends WebTestCase
{
    private $client;

    /**
     * @dataProvider provideUrls
     */
    public function testUrl($url)
    {
        $this->client = static::createClient();

        $this->client->request('GET', $url, [], [], [
            'PHP_AUTH_USER' => 'test0@test.lt',
            'PHP_AUTH_PW'   => 'test0',
        ]);

        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }


    public function provideUrls()
    {
        return [
            ['/'],
            ['/list'],
            ['/contact/new'],
            ['/request'],
            ['/send/1'],
        ];
    }
}