<?php

declare(strict_types=1);

namespace App\User\Application\Registration\Command\Register;

use JetBrains\PhpStorm\Immutable;

#[Immutable]
final class RegisterUserCommand
{
	public function __construct
	(
		public readonly string $email,
		public readonly string $password,
		public readonly string $confirmPassword
	) {}
}