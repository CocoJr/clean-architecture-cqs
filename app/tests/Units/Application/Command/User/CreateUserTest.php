<?php

namespace Tests\Units\Application\Command\User;

use Application\Command\User\Create\CreateUser;
use Domain\User\Command\Create\CreateUserRequest;
use Domain\User\Entity\User;
use Domain\User\Repository\UserRepositoryInterface;
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
            new CreateUserRequest('', '', '')
        );
    }
}
