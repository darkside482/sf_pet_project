<?php

declare(strict_types=1);

namespace App\User\Domain\ValueObject;

use App\User\Domain\Exception\Email\InvalidEmailDomainException;

final class Email
{
	private string $email;

	/**
	 * @throws InvalidEmailDomainException
	 */
	private function __construct(string $email)
	{
		$this->isValidEmailOrFail($email);
		$this->email = $email;
	}

	public static function fromString(string $email): self
	{
		return new self($email);
	}

	private function isValidEmailOrFail(string $email): void
	{
		if (!filter_var($email, FILTER_SANITIZE_EMAIL)) {
			throw InvalidEmailDomainException::fromString($email);
		}
	}

	public function __toString(): string
	{
		return $this->email;
	}
}