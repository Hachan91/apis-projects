<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class SubscriptionControllerTest extends WebTestCase
{
    public function testGetSubscriptions()
    {
        $client = static::createClient();
        $client->request('GET', '/subscription/1');

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testCreateSubscription()
    {
        $client = static::createClient();
        $data = [
            'contact' => 1,
            'product' => 1,
            'beginDate' => '2023-01-01T00:00:00',
            'endDate' => '2024-01-01T00:00:00'
        ];
        $client->request(
            'POST',
            '/subscription',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testUpdateSubscription()
    {
        $client = static::createClient();
        $data = [
            'contact' => 1,
            'product' => 1,
            'beginDate' => '2023-01-01T00:00:00',
            'endDate' => '2024-01-01T00:00:00'
        ];
        $client->request(
            'PUT',
            '/subscription/1',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testDeleteSubscription()
    {
        $client = static::createClient();
        $client->request('DELETE', '/subscription/1');

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }
}