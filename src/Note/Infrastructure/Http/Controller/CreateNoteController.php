<?php

declare(strict_types=1);

namespace App\Note\Infrastructure\Http\Controller;

use App\Note\Application\CreateNote\CreateNoteCommand;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

final class CreateNoteController
{
	public function __construct
	(
		private MessageBusInterface $messageBus,
		private Security $security
	) {}

	#[Route('/note', name: 'create_note', methods: ['POST'])]
	public function __invoke(Request $request): JsonResponse
	{
		$payload = $request->toArray();
		$user = $this->security->getUser();

		$command = new CreateNoteCommand
		(
			$user->getUserIdentifier(),
			$payload['amount'],
			$payload['name'],
			$payload['link'] ?? null,
			$payload['comment'] ?? null
		);

		$this->messageBus->dispatch($command);

		return new JsonResponse([], Response::HTTP_OK);
	}
}