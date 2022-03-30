<?php

namespace App\User\Domain\Exception;

enum Error: int
{
	case DifferentPasswords = 1;
	case EmailExists = 2;
	case InvalidEmail = 3;
	case InvalidPasswordFormat = 4;

	public function getMessage(): string
	{
		return match($this) {
			self::DifferentPasswords => 'Password and confirmation password are not the same!',
			self::EmailExists => 'User with such email %s already exists!',
			self::InvalidEmail => 'Invalid email %s',
			self::InvalidPasswordFormat => 'Invalid password format',
		};
	}

	public function getCode(): int
	{
		return $this->value;
	}
}