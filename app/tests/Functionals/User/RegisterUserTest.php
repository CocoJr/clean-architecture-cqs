<?php

namespace Functionnels\User;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Tests\Builder\UserBuilder;

final class RegisterUserTest extends WebTestCase
{
    public function testPostRegisterUserErrorShouldRedirectWithErrorFlashMessage(): void
    {
        // Arrange
        $client = $this->createClient();

        // Act
        $client->request('POST', '/users/');

        $redirectParams = [
            'form' => 'register',
            'form_errors' => [
                'username' => 'validation.username.length',
                'email' => 'validation.email.required',
                'password' => 'validation.password.length',
            ],
        ];
        $expectedRedirect = '/?'.http_build_query($redirectParams);

        // Assert
        $this->assertResponseRedirects($expectedRedirect);
        $crawler = $client->followRedirect();
        /* @TODO
         * $this->assertSelectorTextContains(
         * 'register.error',
         * $crawler->filter('.alert-danger')->first()->innerText()
         * );
         */
    }

    public function testPostRegisterUserAlreadyExistShouldRedirectWithErrorFlashMessage(): void
    {
        // Arrange
        $client = $this->createClient();
        $entityManager = self::getContainer()->get('doctrine.orm.entity_manager');
        $password = 'password';
        $user = (new UserBuilder())->withPassword($password)->build();

        $entityManager->persist($user);
        $entityManager->flush();

        $redirectParams = [
            'form' => 'register',
            'form_errors' => [
                'email' => 'user.exists',
            ],
        ];
        $expectedRedirect = '/?'.http_build_query($redirectParams);

        // Act
        $client->request('POST', '/users/', ['username' => $user->getUsername(), 'email' => $user->getEmail(), 'password' => $password]);

        // Assert
        $this->assertResponseRedirects($expectedRedirect);
        $crawler = $client->followRedirect();
    }

    public function testPostRegisterUserSuccessShouldRedirectWithSuccessFlashMessage(): void
    {
        // Arrange
        $client = $this->createClient();
        $password = 'password';
        $user = (new UserBuilder())->build();

        // Act
        $client->request('POST', '/users/', ['username' => $user->getUsername(), 'email' => $user->getEmail(), 'password' => $password]);

        // Assert
        $this->assertResponseRedirects('/users/me');
        $crawler = $client->followRedirect();
        $this->assertEquals(
            'register.success',
            $crawler->filter('.alert-success')->first()->innerText()
        );
    }
}
