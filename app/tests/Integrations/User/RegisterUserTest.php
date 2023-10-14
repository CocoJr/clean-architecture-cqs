<?php

namespace Tests\Integrations\User;

use Application\Gateway\User\UserCommandBus;
use Application\Gateway\User\UserQueryBus;
use Application\Query\User\GetByEmail\GetUserByEmailRequest;
use Application\UseCase\User\Register\RegisterUser;
use Application\UseCase\User\Register\RegisterUserRequest;
use Domain\User\Error\UserAlreadyExistsException;
use Domain\User\Model\User;
use Domain\User\Value\Password;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Tests\Builder\UserBuilder;

final class RegisterUserTest extends KernelTestCase
{
    public function testUserShouldBeRegistered(): void
    {
        // Arrange
        $container = self::getContainer();
        $password = 'password';
        $user = (new UserBuilder())->withPassword($password)->build();

        // Act
        $sut = new RegisterUser($container->get(UserQueryBus::class), $container->get(UserCommandBus::class));
        $sut->__invoke(
            new RegisterUserRequest($user->getUsername(), $user->getEmail(), new Password($password))
        );

        // Assert
        $this->assertNotNull(
            $container->get(UserQueryBus::class)
                ->getByEmail(
                    new GetUserByEmailRequest($user->getEmail())
                )
        );
    }

    public function testUserAlreadyExistsShouldNotRegisterUser(): void
    {
        // Assert
        $container = self::getContainer();
        $em = $container->get('doctrine.orm.entity_manager');

        $user = (new UserBuilder())->build();
        $em->persist($user);
        $em->flush();

        $this->expectException(UserAlreadyExistsException::class);

        // Act
        $sut = new RegisterUser($container->get(UserQueryBus::class), $container->get(UserCommandBus::class));
        $sut->__invoke(
            new RegisterUserRequest(
                $user->getUsername(),
                $user->getEmail(),
                new Password('password')
            )
        );

        // Assert
        $this->assertEquals(1, $em->getRepository(User::class)->count());
    }
}
