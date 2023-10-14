<?php

namespace Tests\Integrations\User;

use Application\Gateway\SecurityInterface;
use Application\Gateway\User\UserQueryBus;
use Application\UseCase\User\Login\LoginUser;
use Application\UseCase\User\Login\LoginUserRequest;
use Domain\User\Error\UserLoginFailedException;
use Domain\User\Value\Password;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Tests\Builder\UserBuilder;

final class LoginUserTest extends KernelTestCase
{
    public function testUserShouldBeLogged(): void
    {
        // Arrange
        $container = self::getContainer();

        $requestStack = $this->createMock(RequestStack::class);
        $requestStack->method('getCurrentRequest')->willReturn(new Request());
        $container->set('request_stack', $requestStack);

        $entityManager = $container->get('doctrine.orm.entity_manager');

        $password = 'password';
        $user = (new UserBuilder())->withPassword($password)->build();
        $entityManager->persist($user);
        $entityManager->flush();

        // Act
        $sut = new LoginUser($container->get(UserQueryBus::class), $container->get(SecurityInterface::class));
        $response = $sut->__invoke(
            new LoginUserRequest($user->getEmail(), new Password($password))
        );

        // Assert
        $this->assertNotNull($response->user->getId());
    }

    public function testLoginUserWithInvalidPasswordShouldThrowAnException(): void
    {
        // Arrange
        $container = self::getContainer();

        $requestStack = $this->createMock(RequestStack::class);
        $requestStack->method('getCurrentRequest')->willReturn(new Request());
        $container->set('request_stack', $requestStack);

        $entityManager = $container->get('doctrine.orm.entity_manager');

        $password = 'password';
        $user = (new UserBuilder())->withPassword($password)->build();
        $entityManager->persist($user);
        $entityManager->flush();

        // Assert
        $this->expectException(UserLoginFailedException::class);

        // Act
        $handle = new LoginUser($container->get(UserQueryBus::class), $container->get(SecurityInterface::class));
        $handle->__invoke(
            new LoginUserRequest($user->getEmail(), new Password($password.'_bad'))
        );
    }
}
