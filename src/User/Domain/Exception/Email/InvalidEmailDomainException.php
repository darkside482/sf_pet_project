<?php

declare(strict_types=1);

namespace App\User\Domain\Exception\Email;

use App\Common\Exception\DomainException;
use App\User\Domain\Exception\Error;
use Exception;

class InvalidEmailDomainException extends Exception implements DomainException
{
	public static function fromString(string $email): self
	{
		$error = Error::InvalidEmail;
		return new self
		(
			sprintf($error->getMessage(), $email),
			$error->getCode(),
		);
	}
}