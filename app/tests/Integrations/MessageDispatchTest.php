<?php

namespace Tests\Integrations;

use Application\Command\User\Create\CreateUserRequest;
use Application\Query\User\GetByEmail\GetUserByEmailRequest;
use Application\UseCase\User\Login\LoginUserRequest;
use Application\UseCase\User\Logout\LogoutUserRequest;
use Application\UseCase\User\Register\RegisterUserRequest;
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
