<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Http\Controller;

use App\User\Application\Registration\Command\Login\LoginUserCommand;
use App\User\Application\Registration\Command\Login\LoginUserCommandHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;

final class LoginController
{
	public function __construct
	(
		private MessageBusInterface $messageBus
	) {}

	#[Route('/login', name: 'login', methods: ['POST'])]
	public function __invoke(Request $request): JsonResponse
	{
		$payload = $request->toArray();

		$command = new LoginUserCommand(
			$payload['email'],
			$payload['password']
		);

		/** @see LoginUserCommandHandler */
		$envelope = $this->messageBus->dispatch($command);

		$handledStamp = $envelope->last(HandledStamp::class);
		$token = $handledStamp->getResult();

		return new JsonResponse(['token' => $token], Response::HTTP_OK);
	}
}