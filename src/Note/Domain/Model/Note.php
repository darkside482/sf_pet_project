<?php

declare(strict_types=1);

namespace App\Note\Domain\Model;

use App\User\Domain\Model\User;

class Note
{
	private readonly string $id;

	private string $userId;

	private float $amount;

	private string $name;

	private ?string $link;

	private ?string $comment;

	private function __construct(
		string $id,
		string $userId,
		float $amount,
		string $name,
		?string $link,
		?string $comment
	) {
		$this->id = $id;
		$this->userId = $userId;
		$this->amount = $amount;
		$this->name = $name;
		$this->link = $link;
		$this->comment = $comment;
	}

	public static function create(
		string $id,
		string $userId,
		float $amount,
		string $name,
		?string $link = null,
		?string $comment = null
	): self
	{
		return new self($id, $userId, $amount, $name, $link, $comment);
	}
}