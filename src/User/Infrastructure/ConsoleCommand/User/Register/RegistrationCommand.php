<?php

declare(strict_types=1);

namespace App\User\Infrastructure\ConsoleCommand\User\Register;

use App\User\API\Register\RegisterUserInterface;
use App\User\Application\Registration\Command\Register\RegisterUserCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class RegistrationCommand extends Command implements RegisterUserInterface
{
	protected static $defaultName = 'user:register';

	private const EMAIL_ARGUMENT = 'email';
	private const PASSWORD_ARGUMENT = 'password';
	private const CONFIRM_PASSWORD_ARGUMENT = 'confirmPassword';

	public function __construct
	(
		private MessageBusInterface $messageBus,
		string $name = null
	)
	{
		parent::__construct($name);
	}

	public function configure()
	{
		$this
			->addArgument(self::EMAIL_ARGUMENT, InputArgument::OPTIONAL, 'user email', 'test@google.com')
			->addArgument(self::PASSWORD_ARGUMENT, InputArgument::OPTIONAL, 'user password', '12345678')
			->addArgument(self::CONFIRM_PASSWORD_ARGUMENT, InputArgument::OPTIONAL, 'confirmation password', '12345678');
	}

	public function execute(InputInterface $input, OutputInterface $output): int
	{
		$command = new RegisterUserCommand
		(
			$input->getArgument(self::EMAIL_ARGUMENT),
			$input->getArgument(self::PASSWORD_ARGUMENT),
			$input->getArgument(self::CONFIRM_PASSWORD_ARGUMENT),
		);

		$envelope = $this->messageBus->dispatch($command);

		$output->writeln('userId: ' . $envelope->last(HandledStamp::class)->getResult());

		return Command::SUCCESS;
	}
}