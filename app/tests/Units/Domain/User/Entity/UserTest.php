<?php

namespace Tests\Units\Domain\User\Entity;

use PHPUnit\Framework\TestCase;
use Tests\Builder\UserBuilder;

final class UserTest extends TestCase
{
    public function testUserEntityGetterShouldReturnCorrectValue(): void
    {
        // Arrange
        $expectedPassword = 'password';
        $expectedRoles = ['ROLE_USER'];

        $user = (new UserBuilder())->withPassword($expectedPassword)->build();

        // Assert
        $this->assertNotNull($user->getEmail());
        $this->assertNotNull($user->getUsername());
        $this->assertNotNull($user->getPassword());
        $this->assertTrue($user->checkPassword($expectedPassword));
        $this->assertNull($user->getCreatedAt());
        $this->assertNull($user->getUpdatedAt());
        $this->assertEquals($expectedRoles, $user->getRoles());
    }
}
