<?php

declare(strict_types=1);

namespace App\User\Domain\Model;

use App\User\Domain\Exception\Password\InvalidPasswordFormatDomainException;
use App\User\Domain\Exception\User\DifferentPasswordsDomainException;
use App\User\Domain\ValueObject\Email;
use App\User\Domain\ValueObject\Password;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

class User implements PasswordAuthenticatedUserInterface
{
	private readonly string $id;

	private Email $email;

	private Password $password;

	private bool $emailConfirmed;

	private Collection $notes;

	private function __construct(string $id, string $email)
	{
		$this->id = $id;
		$this->email = Email::fromString($email);
	}

	/**
	 * @throws DifferentPasswordsDomainException
	 */
	public static function register
	(
		string $id,
		string $email,
		string $password,
		string $confirmPassword
	): self
	{
		self::assertThatPasswordsAreTheSame($password, $confirmPassword);
		return new self($id, $email);
	}

	public function confirmEmail(): void
	{
		$this->emailConfirmed = true;
	}

	/**
	 * @throws InvalidPasswordFormatDomainException
	 */
	public function setPasswordHash(string $passwordHash): void
	{
		$this->password = Password::fromHash($passwordHash);
	}

	/**
	 * @throws DifferentPasswordsDomainException
	 */
	private static function assertThatPasswordsAreTheSame(string $password, string $confirmPassword): void
	{
		if ($password !== $confirmPassword) {
			throw DifferentPasswordsDomainException::create();
		}
	}

	public function getId(): string
	{
		return $this->id;
	}

	public function getPassword(): string
	{
		return (string)$this->password;
	}
}