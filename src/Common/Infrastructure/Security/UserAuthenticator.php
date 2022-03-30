<?php

namespace App\Common\Infrastructure\Security;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

class UserAuthenticator extends AbstractAuthenticator
{

	private const TOKEN_HEADER = 'Authorization';

	public function __construct
	(
		private TokenGenerator $tokenGenerator
	) {}

	public function supports(Request $request): ?bool
	{
		return $request->headers->has(self::TOKEN_HEADER);
	}

	public function authenticate(Request $request): Passport
	{
		$apiToken = $request->headers->get(self::TOKEN_HEADER);
		if (null === $apiToken || !$this->tokenGenerator->hasToken($apiToken)) {
			throw new CustomUserMessageAuthenticationException('No API token provided');
		}

		$userData = $this->tokenGenerator->getData($apiToken);

		return new SelfValidatingPassport(new UserBadge($userData['id']));
	}

	public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
	{
		return null;
	}

	public function onAuthenticationFailure(Request $request, AuthenticationException $exception): Response
	{
		return new JsonResponse([], Response::HTTP_UNAUTHORIZED);
	}
}