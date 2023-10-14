<?php

namespace Tests\Integrations\User;

use Domain\Shared\Exception\ValidationException;
use Domain\Shared\Gateway\MessageBusInterface;
use Domain\User\Exception\UserAlreadyExistsException;
use Domain\User\Query\GetByEmail\GetUserByEmailRequest;
use Domain\User\Query\GetByEmail\GetUserByEmailResponse;
use Domain\User\UseCase\Register\RegisterUser;
use Domain\User\UseCase\Register\RegisterUserRequest;
use PHPUnit\Framework\TestCase;
use Tests\Builder\UserBuilder;

final class RegisterUserTest extends TestCase
{
    public function testUserShouldBeRegistered(): void
    {
        // Arrange
        $password = 'password';
        $user = (new UserBuilder())->withPassword($password)->build();

        $busMock = $this
            ->getMockBuilder(MessageBusInterface::class)
            ->setMockClassName('MessageBus')
            ->disableOriginalConstructor()
            ->getMock();

        // Assert
        $busMock
            ->expects($this->exactly(2))
            ->method('send')
            ->willReturnOnConsecutiveCalls(
                null,
                null,
            );

        // Act
        $sut = new RegisterUser($busMock);
        $sut->__invoke(
            new RegisterUserRequest($user->getUsername(), $user->getEmail(), $password)
        );
    }

    public function testUserAlreadyExistsShouldNotRegisterUser(): void
    {
        // Arrange
        $busMock = $this
            ->getMockBuilder(MessageBusInterface::class)
            ->setMockClassName('MessageBus')
            ->disableOriginalConstructor()
            ->getMock();

        // Assert
        $busMock
            ->expects($this->once())
            ->method('send')
            ->with($this->isInstanceOf(GetUserByEmailRequest::class))
            ->willReturn(new GetUserByEmailResponse((new UserBuilder())->build()))
        ;

        $this->expectException(UserAlreadyExistsException::class);

        // Act
        $sut = new RegisterUser($busMock);
        $sut->__invoke(
            new RegisterUserRequest('username', 'email@email.com', 'password')
        );
    }

    public function testRegisterUserWithEmptyValueShouldThrowValidation(): void
    {
        // Arrange
        $busMock = $this
            ->getMockBuilder(MessageBusInterface::class)
            ->setMockClassName('MessageBus')
            ->disableOriginalConstructor()
            ->getMock();

        try {
            // Act
            $sut = new RegisterUser($busMock);
            $sut->__invoke(
                new RegisterUserRequest('', '', '')
            );
        } catch (ValidationException $exception) {
            // Assert
            $errors = $exception->getErrors();
            $this->assertEquals('validation.username.length', $errors['username']);
            $this->assertEquals('validation.email.required', $errors['email']);
            $this->assertEquals('validation.password.length', $errors['password']);
        }
    }

    public function testRegisterUserWithInvalidEmailShouldThrowValidation(): void
    {
        // Arrange
        $busMock = $this
            ->getMockBuilder(MessageBusInterface::class)
            ->setMockClassName('MessageBus')
            ->disableOriginalConstructor()
            ->getMock();

        try {
            // Act
            $sut = new RegisterUser($busMock);
            $sut->__invoke(
                new RegisterUserRequest('test', 'test', 'test')
            );
        } catch (ValidationException $exception) {
            // Assert
            $errors = $exception->getErrors();
            $this->assertEquals('validation.email.invalid', $errors['email']);
        }
    }
}
