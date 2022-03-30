<?php

declare(strict_types=1);

namespace App\Note\Domain\Repository;

use App\Note\Domain\Model\Note;

interface NoteRepositoryInterface
{
	public function nextIdentity(): string;

	public function save(Note $note): void;

	public function clear(): void;

	public function flush(): void;
}