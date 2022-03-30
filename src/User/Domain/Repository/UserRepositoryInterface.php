<?php

declare(strict_types=1);

namespace App\User\Domain\Repository;

use App\User\Domain\Model\User;

interface UserRepositoryInterface
{
	public function getById(string $id): User;

	public function nextIdentity(): string;

	public function findByEmail(string $email): ?User;

	public function getByEmail(string $email): User;

	public function save(User $user): void;

	public function flush(): void;
}