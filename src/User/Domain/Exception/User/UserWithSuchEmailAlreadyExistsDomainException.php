<?php

declare(strict_types=1);

namespace App\User\Domain\Exception\User;

use App\Common\Exception\DomainException;
use App\User\Domain\Exception\Error;
use Exception;

final class UserWithSuchEmailAlreadyExistsDomainException extends Exception implements DomainException
{
	public static function create(string $email): self
	{
		$error = Error::EmailExists;
		return new self(
			sprintf($error->getMessage(), $email),
			$error->getCode(),
		);
	}
}