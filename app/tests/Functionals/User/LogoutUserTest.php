<?php

namespace Tests\Functionnels\User;

use Infrastructure\Symfony\Security\SecurityUser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Tests\Builder\UserBuilder;

final class LogoutUserTest extends WebTestCase
{
    public function testLogoutUserNotLoggedShouldThrowHttpException(): void
    {
        // Arrange
        $client = $this->createClient();
        $client->catchExceptions(false);

        $this->expectException(AccessDeniedException::class);

        // Act
        $client->request('GET', '/users/logout');

        // Assert
        $this->assertResponseStatusCodeSame(401);
    }

    public function testLogoutUserLoggedShouldRedirect(): void
    {
        // Arrange
        $client = $this->createClient();
        $entityManager = self::getContainer()->get('doctrine.orm.entity_manager');
        $password = 'password';
        $user = (new UserBuilder())->withPassword($password)->build();

        $entityManager->persist($user);
        $entityManager->flush();

        $securityUser = new SecurityUser($user);
        $client->loginUser($securityUser);

        // Act
        $client->request('GET', '/users/logout');

        // Assert
        $this->assertResponseRedirects('/');
    }
}
