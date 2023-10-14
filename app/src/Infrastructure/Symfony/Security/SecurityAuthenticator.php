<?php

namespace Infrastructure\Symfony\Security;

use Domain\User\Repository\UserRepositoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

final class SecurityAuthenticator extends AbstractAuthenticator
{
    private const LOGIN_URL = '/api/users/login';

    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }

    public function supports(Request $request): ?bool
    {
        return self::LOGIN_URL === $request->getRequestUri();
    }

    public function authenticate(Request $request): Passport
    {
        $body = json_decode($request->getContent());
        $user = $this->userRepository->getByEmail($body->email);

        if (!$user) {
            throw new AuthenticationException('User not found');
        }

        $userIdentifier = new SecurityUser($user);

        return new SelfValidatingPassport(new UserBadge($userIdentifier->getUserIdentifier()));
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $data = [
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData()),
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }
}
