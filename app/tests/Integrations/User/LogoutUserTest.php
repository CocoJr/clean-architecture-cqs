<?php

namespace Tests\Integrations\User;

use Application\Gateway\SecurityInterface;
use Application\UseCase\User\Logout\LogoutUser;
use Application\UseCase\User\Logout\LogoutUserRequest;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class LogoutUserTest extends KernelTestCase
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
        $sut->__invoke(new LogoutUserRequest());
    }
}
