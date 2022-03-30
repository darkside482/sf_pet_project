<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Http\Controller;

use App\User\API\Register\RegisterUserInterface;
use App\User\Application\Registration\Command\Register\RegisterUserCommand;
use App\User\Application\Registration\Command\Register\RegisterUserCommandHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

final class RegistrationController implements RegisterUserInterface
{

	public function __construct(private MessageBusInterface $messageBus) {}

	#[Route('/register', name: 'register_user', methods: ['POST'])]
	public function __invoke(Request $request): JsonResponse
	{
		$arrayRequest = $request->toArray();

		$command = new RegisterUserCommand
		(
			$arrayRequest['email'],
			$arrayRequest['password'],
			$arrayRequest['confirmPassword'],
		);

		/** @see RegisterUserCommandHandler */
		$this->messageBus->dispatch($command);

		return new JsonResponse();
	}
}