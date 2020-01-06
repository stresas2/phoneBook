<?php


namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;


class UserNotAvailableUrlTest extends WebTestCase
{
    private $client;

    public function testUrl()
    {
        $this->client = static::createClient();

        $this->client->request('GET', '/login', [], [], [
            'PHP_AUTH_USER' => 'test0@test.lt',
            'PHP_AUTH_PW' => 'test0',
        ]);

        $this->assertNotSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }


}