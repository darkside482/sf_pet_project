<?php

declare(strict_types=1);

namespace App\User\Application\Registration\Command\Login;

use App\Common\Infrastructure\Security\TokenGenerator;
use App\User\Domain\Repository\UserRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class LoginUserCommandHandler implements MessageHandlerInterface
{
	public function __construct
	(
		private UserRepositoryInterface $userRepository,
		private UserPasswordHasherInterface $passwordHasher,
		private TokenGenerator $tokenGenerator,
	) {}

	public function __invoke(LoginUserCommand $command): string
	{
		$user = $this->userRepository->getByEmail($command->email);

		if (!$this->passwordHasher->isPasswordValid($user, $command->password)) {
			throw new AccessDeniedHttpException();
		}

		return $this->tokenGenerator->create($user->getId());
	}
}