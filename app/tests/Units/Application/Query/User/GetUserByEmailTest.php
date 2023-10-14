<?php

namespace Tests\Units\Application\Query\User;

use Application\Query\User\GetByEmail\GetUserByEmail;
use Application\Query\User\GetByEmail\GetUserByEmailRequest;
use Domain\User\Error\UserNotExistsException;
use Domain\User\Repository\UserRepositoryInterface;
use Domain\User\Value\Email;
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

        $repositoryMock
            ->expects($this->once())
            ->method('getByEmail')
            ->with($expectedEmail)
            ->willReturn($user);

        // Act
        $sut = new GetUserByEmail($repositoryMock);
        $response = $sut->__invoke(
            new GetUserByEmailRequest(new Email($expectedEmail))
        );

        // Assert
        $this->assertEquals($user->getId(), $response->user->getId());
        $this->assertEquals($user->getEmail(), $response->user->getEmail());
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
            new GetUserByEmailRequest(new Email($expectedEmail))
        );
    }
}
