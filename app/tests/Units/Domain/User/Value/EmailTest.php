<?php

namespace Tests\Units\Domain\User\Value;

use Domain\Shared\Error\ValidationException;
use Domain\User\Value\Email;
use PHPUnit\Framework\TestCase;
use Tests\FakerUtility;

final class EmailTest extends TestCase
{
    public function testEmailShouldContainsArobase(): void
    {
        // Arrange
        $email = 'email';

        // Act
        try {
            new Email($email);
        } catch (ValidationException $e) {
            // Assert
            $this->assertEquals(['email' => 'validation.email.invalid'], $e->getErrors());
        }
    }

    /**
     * @dataProvider provideValidEmail
     */
    public function testValidEmail(string $email): void
    {
        // Act
        $emailValue = new Email($email);

        // Assert
        $this->assertEquals($email, $emailValue->getValue());
    }

    public function provideValidEmail(): iterable
    {
        for ($i = 0; $i < 5; ++$i) {
            $email = FakerUtility::getGenerator()->email();

            yield "Email \"$email\" should be valid" => ['email' => $email];
        }
    }
}
