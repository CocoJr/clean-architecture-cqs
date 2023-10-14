<?php

namespace Tests\Units\Application\Query\User;

use Application\Query\User\GetByEmail\GetUserByEmail;
use Domain\User\Exception\UserNotExistsException;
use Domain\User\Query\GetByEmail\GetUserByEmailRequest;
use Domain\User\Repository\UserRepositoryInterface;
use PHPUnit\Framework\TestCase;
use Tests\Builder\UserBuilder;

final class GetUserByEmailTest extends TestCase
{
    public function testGetUserByEmail(): void
    {
        // Arrange
        $expectedEmail = 'test@test.fr';
        $user = (new UserBuilder())->build();

        $repositoryMock = $this
            ->getMockBuilder(UserRepositoryInterface::class)
            ->setMockClassName('UserRepository')
            ->disableOriginalConstructor()
            ->getMock();

        // Assert
        $repositoryMock
            ->expects($this->once())
            ->method('getByEmail')
            ->with($expectedEmail)
            ->willReturn($user);

        // Act
        $sut = new GetUserByEmail($repositoryMock);
        $sut->__invoke(
            new GetUserByEmailRequest($expectedEmail)
        );
    }

    public function testGetUserByEmailShouldThrowUserNotExists(): void
    {
        // Arrange
        $expectedEmail = 'test@test.fr';

        $repositoryMock = $this
            ->getMockBuilder(UserRepositoryInterface::class)
            ->setMockClassName('UserRepository')
            ->disableOriginalConstructor()
            ->getMock();

        // Assert
        $repositoryMock
            ->expects($this->once())
            ->method('getByEmail')
            ->with($expectedEmail)
            ->willReturn(null);

        $this->expectException(UserNotExistsException::class);

        // Act
        $sut = new GetUserByEmail($repositoryMock);
        $sut->__invoke(
            new GetUserByEmailRequest($expectedEmail)
        );
    }
}
