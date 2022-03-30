<?php

declare(strict_types=1);

namespace App\User\Domain\Exception\User;

use App\Common\Exception\DomainException;
use App\User\Domain\Exception\Error;
use Exception;

final class DifferentPasswordsDomainException extends Exception implements DomainException
{
	public static function create(): self
	{
		$error = Error::DifferentPasswords;
		return new self
		(
			$error->getMessage(),
			$error->getCode(),
		);
	}
}