<?php

namespace Tests\Units\Domain\User\Value;

use Domain\Shared\Error\ValidationException;
use Domain\User\Value\Password;
use PHPUnit\Framework\TestCase;
use Tests\FakerUtility;

final class PasswordTest extends TestCase
{
    public function testPasswordShouldNotContainsLessThan4Characters(): void
    {
        // Arrange
        $password = FakerUtility::getGenerator()->password(1, 3);

        // Act
        try {
            new Password($password);
        } catch (ValidationException $e) {
            // Assert
            $this->assertEquals(['password' => 'validation.password.length'], $e->getErrors());
        }
    }

    public function testPasswordShouldNotContainsMoreThan100Characters(): void
    {
        // Arrange
        $password = FakerUtility::getGenerator()->password(101, 101);

        // Act
        try {
            new Password($password);
        } catch (ValidationException $e) {
            // Assert
            $this->assertEquals(['password' => 'validation.password.length'], $e->getErrors());
        }
    }

    /**
     * @dataProvider provideValidPassword
     */
    public function testValidPassword(string $password): void
    {
        // Act
        $passwordValue = new Password($password);

        // Assert
        $this->assertEquals($password, $passwordValue->getValue());
    }

    public function provideValidPassword(): iterable
    {
        yield 'Min password length' => [
            'password' => FakerUtility::getGenerator()->password(4, 4),
        ];

        yield 'Max password length' => [
            'password' => FakerUtility::getGenerator()->password(100, 100),
        ];

        for ($i = 0; $i < 5; ++$i) {
            $password = FakerUtility::getGenerator()->password(4, 100);

            yield "Password \"$password\" should be valid" => ['password' => $password];
        }
    }
}
