<?php

namespace Tests\Integrations;

use Domain\User\Command\Create\CreateUserRequest;
use Domain\User\Query\GetByEmail\GetUserByEmailRequest;
use Domain\User\UseCase\Login\LoginUserRequest;
use Domain\User\UseCase\Logout\LogoutUserRequest;
use Domain\User\UseCase\Register\RegisterUserRequest;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Process\Process;

final class MessageDispatchTest extends KernelTestCase
{
    /**
     * @dataProvider messageTypesDataProvider
     */
    public function testMessageShouldBeRegisteredInTheBus($messageType, $output)
    {
        $this->assertStringContainsString($messageType, $output);
    }

    public function messageTypesDataProvider(): iterable
    {
        $process = Process::fromShellCommandline('bin/console debug:messenger');
        $process->run();
        $output = $process->getOutput();

        yield 'GetUserByEmailRequest' => [GetUserByEmailRequest::class, $output];
        yield 'CreateUserRequest' => [CreateUserRequest::class, $output];
        yield 'LoginUserRequest' => [LoginUserRequest::class, $output];
        yield 'LogoutUserRequest' => [LogoutUserRequest::class, $output];
        yield 'RegisterUserRequest' => [RegisterUserRequest::class, $output];
    }
}
