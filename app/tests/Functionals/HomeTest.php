<?php

namespace Tests\Functionnels;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class HomeTest extends WebTestCase
{
    public function testPageShouldBeRendered(): void
    {
        // Arrange
        $client = $this->createClient();

        // Act
        $client->request('get', '/');

        // Assert
        $this->assertResponseIsSuccessful();
    }
}
