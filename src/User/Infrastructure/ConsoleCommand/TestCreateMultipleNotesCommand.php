<?php

declare(strict_types=1);

namespace App\User\Infrastructure\ConsoleCommand;

use App\Note\Domain\Model\Note;
use App\Note\Domain\Repository\NoteRepositoryInterface;
use App\User\Domain\Repository\UserRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Uid\Ulid;

class TestCreateMultipleNotesCommand extends Command
{

	protected static $defaultName = 'test:notes';

	public function __construct(
		private NoteRepositoryInterface $noteRepository,
		private UserRepositoryInterface $userRepository,
	) {
		parent::__construct();
	}


	public function execute(InputInterface $input, OutputInterface $output)
	{

		$output->writeln('Start!');
		$user = $this->userRepository->getById('017f03ec-566c-7006-0e17-062f150d22dd');

		$startTime = time();
		for ($i = 1; $i <= 10; $i++) {

			$note = Note::create(
				$this->noteRepository->nextIdentity(),
				$user->getId(),
				(float)random_int(1, 99999999),
				bin2hex(random_bytes(16))
			);

			$this->noteRepository->save($note);

			if ($i % 1000 === 0) {
				$output->writeln('wtf' . $i);
				$output->writeln('123');
				$this->noteRepository->flush();
				$this->noteRepository->clear();
				$output->writeln('Создано ' . $i . ' записей...');
				$output->writeln('Прошло секунд: ' . time() - $startTime);
			}
		}

		$output->writeln('Завершено!');

		return self::SUCCESS;
	}
}