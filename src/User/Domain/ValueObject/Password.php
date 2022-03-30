<?php

declare(strict_types=1);

namespace App\User\Domain\ValueObject;

use App\User\Domain\Exception\Password\InvalidPasswordFormatDomainException;

final class Password
{

	private string $password;

	/**
	 * @throws InvalidPasswordFormatDomainException
	 */
	public function __construct(string $passwordHash)
	{
		$this->password = $passwordHash;
	}

	/**
	 * @throws InvalidPasswordFormatDomainException
	 */
	public static function fromHash(string $passwordHash): self
	{
		return new self($passwordHash);
	}

	public function __toString(): string
	{
		return $this->password;
	}
}