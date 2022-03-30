<?php

declare(strict_types=1);

namespace App\Note\Infrastructure\Repository;

use App\Note\Domain\Model\Note;
use App\Note\Domain\Repository\NoteRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Ulid;

final class NoteRepository extends ServiceEntityRepository implements NoteRepositoryInterface
{

	public function __construct(ManagerRegistry $registry)
	{
		parent::__construct($registry, Note::class);
	}

	public function nextIdentity(): string
	{
		return (new Ulid())->toRfc4122();
	}

	public function save(Note $note): void
	{
		$this->getEntityManager()->persist($note);
	}

	public function flush(): void
	{
		$this->getEntityManager()->flush();
	}

	public function clear(): void
	{
		$this->getEntityManager()->clear();
	}
}