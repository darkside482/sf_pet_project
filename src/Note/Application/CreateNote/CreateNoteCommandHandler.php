<?php

declare(strict_types=1);

namespace App\Note\Application\CreateNote;

use App\Note\Domain\Model\Note;
use App\Note\Domain\Repository\NoteRepositoryInterface;
use App\User\Domain\Repository\UserRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class CreateNoteCommandHandler implements MessageHandlerInterface
{

	public function __construct
	(
		private NoteRepositoryInterface $noteRepository,
		private UserRepositoryInterface $userRepository
	) {}

	public function __invoke(CreateNoteCommand $command): void
	{
		$user = $this->userRepository->getById($command->userId);

		$note = Note::create(
			$this->noteRepository->nextIdentity(),
			$user->getId(),
			$command->amount,
			$command->name,
			$command->link,
			$command->comment
		);

		$this->noteRepository->save($note);
	}
}