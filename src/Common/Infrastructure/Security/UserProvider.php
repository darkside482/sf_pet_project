<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Security;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{

	public function refreshUser(UserInterface $user)
	{
		return $user;
	}

	public function supportsClass(string $class)
	{
		return $class === User::class;
	}

	public function loadUserByIdentifier(string $identifier): UserInterface
	{
		return new User($identifier);
	}
}