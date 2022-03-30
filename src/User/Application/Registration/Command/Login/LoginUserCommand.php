<?php

declare(strict_types=1);

namespace App\User\Application\Registration\Command\Login;

class LoginUserCommand
{
	public function __construct
	(
		public readonly string $email,
		public readonly string $password
	) {}
}