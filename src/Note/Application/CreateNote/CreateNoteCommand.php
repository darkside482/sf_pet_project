<?php

declare(strict_types=1);

namespace App\Note\Application\CreateNote;

final class CreateNoteCommand
{
	public function __construct
	(
		public readonly string $userId,
		public readonly float $amount,
		public readonly string $name,
		public readonly ?string $link,
		public readonly ?string $comment
	) {}
}