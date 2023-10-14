<?php

namespace Tests\Functionnels\User;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Tests\Builder\UserBuilder;

final class LoginUserTest extends WebTestCase
{
    public function testPostLoginUserErrorShouldRedirectWithErrorFlashMessage(): void
    {
        // Arrange
        $client = $this->createClient();

        // Act
        $client->request('POST', '/users/login');

        // Assert
        $this->assertResponseRedirects('/');
        $crawler = $client->followRedirect();
        $this->assertEquals(
            'login.error',
            $crawler->filter('.alert-danger')->first()->innerText()
        );
    }

    public function testPostLoginUserNotExistShouldRedirectWithErrorFlashMessage(): void
    {
        // Arrange
        $client = $this->createClient();

        // Act
        $client->request('POST', '/users/login', ['email' => 'email@email.fr', 'password' => 'mypasswd']);

        // Assert
        $this->assertResponseRedirects('/');
        $crawler = $client->followRedirect();
        $this->assertEquals(
            'login.error',
            $crawler->filter('.alert-danger')->first()->innerText()
        );
    }

    public function testPostLoginUserSuccessShouldRedirectWithSuccessFlashMessage(): void
    {
        // Arrange
        $client = $this->createClient();
        $entityManager = self::getContainer()->get('doctrine.orm.entity_manager');
        $password = 'password';
        $user = (new UserBuilder())->withPassword($password)->build();

        $entityManager->persist($user);
        $entityManager->flush();

        // Act
        $client->request('POST', '/users/login', ['email' => $user->getEmail(), 'password' => $password]);

        // Assert
        $this->assertResponseRedirects('/users/me');
        $crawler = $client->followRedirect();
        $this->assertEquals(
            'login.success',
            $crawler->filter('.alert-success')->first()->innerText()
        );
    }
}
