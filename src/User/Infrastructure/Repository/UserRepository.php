<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Repository;

use App\User\Domain\Model\User;
use App\User\Domain\Repository\UserRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Ulid;

final class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
	public function __construct(ManagerRegistry $registry)
	{
		parent::__construct($registry, User::class);
	}

	public function getById(string $id): User
	{
		$user = $this->find($id);

		if (!$user) {
			throw EntityNotFoundException::fromClassNameAndIdentifier($this->getClassName(), [$id]);
		}

		return $user;
	}

	public function nextIdentity(): string
	{
		return Ulid::generate();
	}

	public function findByEmail(string $email): ?User
	{
		return null;
	}

	public function getByEmail(string $email): User
	{
		$user = $this->findOneBy(['email.email' => $email]);

		if (!$user) {
			throw new EntityNotFoundException();
		}

		return $user;
	}

	public function save(User $user): void
	{
		$this->getEntityManager()->persist($user);
	}

	public function flush(): void
	{
		$this->getEntityManager()->flush();
	}
}