<?php

declare(strict_types=1);

namespace App\Common\Domain;

trait AggregateRoot
{
	private array $events = [];

	public function append(DomainEventInterface $domainEvent): void
	{
		$this->events[] = $domainEvent;
	}

	public function raiseEvents(): array
	{
		$events = $this->events;
		$this->events = [];

		return $events;
	}
}