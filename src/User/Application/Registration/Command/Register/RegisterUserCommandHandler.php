<?php

declare(strict_types=1);

namespace App\User\Application\Registration\Command\Register;

use App\User\Domain\Exception\Password\InvalidPasswordFormatDomainException;
use App\User\Domain\Exception\User\DifferentPasswordsDomainException;
use App\User\Domain\Exception\User\UserWithSuchEmailAlreadyExistsDomainException;
use App\User\Domain\Model\User;
use App\User\Domain\Repository\UserRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class RegisterUserCommandHandler implements MessageHandlerInterface
{

	public function __construct
	(
		private UserRepositoryInterface $userRepository,
		private UserPasswordHasherInterface $passwordHasher,
	) {}

	/**
	 * @param RegisterUserCommand $command
	 *
	 * @throws DifferentPasswordsDomainException
	 * @throws UserWithSuchEmailAlreadyExistsDomainException
	 * @throws InvalidPasswordFormatDomainException
	 */
	public function __invoke(RegisterUserCommand $command): void
	{
		$userWithSameEmail = $this->userRepository->findByEmail($command->email);

		if ($userWithSameEmail) {
			throw UserWithSuchEmailAlreadyExistsDomainException::create($command->email);
		}

		$user = User::register
		(
			$this->userRepository->nextIdentity(),
			$command->email,
			$command->password,
			$command->confirmPassword,
		);

		$user->setPasswordHash($this->passwordHasher->hashPassword($user, $command->password));

		$this->userRepository->save($user);
	}
}