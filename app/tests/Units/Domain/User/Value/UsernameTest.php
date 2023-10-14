<?php

namespace Tests\Units\Domain\User\Value;

use Domain\Shared\Error\ValidationException;
use Domain\User\Value\Username;
use PHPUnit\Framework\TestCase;
use Tests\FakerUtility;

final class UsernameTest extends TestCase
{
    public function testUsernameShouldNotContainsLessThan3Characters(): void
    {
        // Arrange
        $username = FakerUtility::getGenerator()->password(1, 2);

        // Act
        try {
            new Username($username);
        } catch (ValidationException $e) {
            // Assert
            $this->assertEquals(['username' => 'validation.username.length'], $e->getErrors());
        }
    }

    public function testUsernameShouldNotContainsMoreThan20Characters(): void
    {
        // Arrange
        $username = FakerUtility::getGenerator()->password(21, 21);

        // Act
        try {
            new Username($username);
        } catch (ValidationException $e) {
            // Assert
            $this->assertEquals(['username' => 'validation.username.length'], $e->getErrors());
        }
    }

    /**
     * @dataProvider provideValidUsername
     */
    public function testValidUsername(string $username): void
    {
        // Act
        $usernameValue = new Username($username);

        // Assert
        $this->assertEquals($username, $usernameValue->getValue());
    }

    public function provideValidUsername(): iterable
    {
        for ($i = 0; $i < 5; ++$i) {
            $username = FakerUtility::getGenerator()->password(3, 20);

            yield "Username \"$username\" should be valid" => ['username' => $username];
        }
    }
}
