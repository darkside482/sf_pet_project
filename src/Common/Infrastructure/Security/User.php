<?php

namespace App\Common\Infrastructure\Security;

use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface
{

	private const ROLE_USER = 'ROLE_USER';

	public function __construct(
		private readonly string $id,
	) {}

	public function getRoles(): array
	{
		return [self::ROLE_USER];
	}

	public function eraseCredentials()
	{
	}

	public function getUserIdentifier(): string
	{
		return $this->id;
	}
}