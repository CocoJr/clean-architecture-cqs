<?php

namespace Tests\Units\Application\Command\User;

use Application\Command\User\Create\CreateUser;
use Application\Command\User\Create\CreateUserRequest;
use Domain\User\Model\User;
use Domain\User\Repository\UserRepositoryInterface;
use Domain\User\Value\Email;
use Domain\User\Value\Password;
use Domain\User\Value\Role;
use Domain\User\Value\Roles;
use Domain\User\Value\Username;
use PHPUnit\Framework\TestCase;
use Tests\Builder\UserBuilder;

final class CreateUserTest extends TestCase
{
    public function testCreateUserShouldCallRepository(): void
    {
        // Arrange
        $repositoryMock = $this
            ->getMockBuilder(UserRepositoryInterface::class)
            ->setMockClassName('UserRepository')
            ->disableOriginalConstructor()
            ->getMock();

        // Assert
        $repositoryMock
            ->expects($this->once())
            ->method('save')
            ->with($this->isInstanceOf(User::class))
            ->willReturn((new UserBuilder())->build());

        // Act
        $sut = new CreateUser($repositoryMock);
        $sut->__invoke(
            new CreateUserRequest(
                new Username('username'),
                new Email('email@test.fr'),
                new Password('password'),
                new Roles(new Role('ROLE_USER')),
            )
        );
    }
}
