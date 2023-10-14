<?php

namespace Tests\Integrations\User;

use Domain\Shared\Gateway\SecurityInterface;
use Domain\User\UseCase\Logout\LogoutUser;
use Domain\User\UseCase\Logout\LogoutUserRequest;
use PHPUnit\Framework\TestCase;

final class LogoutUserTest extends TestCase
{
    public function testUserLogoutShouldCallTheSecurityService(): void
    {
        // Arrange
        $securityMock = $this
            ->getMockBuilder(SecurityInterface::class)
            ->setMockClassName('Security')
            ->disableOriginalConstructor()
            ->getMock();

        $securityMock
            ->expects($this->once())
            ->method('logout')
        ;

        // Act
        $sut = new LogoutUser($securityMock);
        $sut->__invoke(
            new LogoutUserRequest()
        );
    }
}
