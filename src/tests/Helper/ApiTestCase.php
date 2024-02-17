<?php

namespace App\Tests\Helper;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class ApiTestCase extends WebTestCase
{
    protected KernelBrowser $client;

    protected function setUp(): void
    {
        $this->client = parent::createClient();
    }

    /** @return array<string, mixed> */
    protected function getJsonResponseData(): array
    {
        $this->assertResponseFormatSame('json');
        return json_decode($this->client->getResponse()->getContent(), true);
    }
}