<?php

declare(strict_types=1);

namespace App\User\Domain\Exception\Password;

use App\Common\Exception\DomainException;
use App\User\Domain\Exception\Error;
use Exception;

class InvalidPasswordFormatDomainException extends Exception implements DomainException
{
	public static function create(): self
	{
		$error = Error::InvalidPasswordFormat;
		return new self
		(
			$error->getMessage(),
			$error->getCode(),
		);
	}
}