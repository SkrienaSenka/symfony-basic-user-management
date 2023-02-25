<?php

namespace App\Controller;

use App\Entity\User;
use App\Manager\UserManager;
use App\Model\Request\User\UserRegistrationInputRequest;
use App\Response\JsonResponse;
use App\Transformer\UserTransformer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/api/security')]
class SecurityController extends AbstractController
{
	public function __construct(
		private readonly UserManager $userManager,
		private readonly UserTransformer $userTransformer,
	) {
	}

	#[Route(path: '/login', name: 'login', methods: ['POST'])]
	public function login(): JsonResponse
	{
		if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
			return new JsonResponse(['message' => 'missing_credentials'], Response::HTTP_UNAUTHORIZED);
		}

		/* @var User $user */
		$user = $this->getUser();

		return new JsonResponse($this->userTransformer->transformToUserOutput($user));
	}

	#[Route('/logout', name: 'logout', methods: ['GET'])]
	public function logout(): void
	{
	}

	#[Route(path: '/register', name: 'register', methods: ['POST'])]
	public function register(UserRegistrationInputRequest $request): JsonResponse
	{
		$user = $this->userManager->register($request);

		return new JsonResponse($this->userTransformer->transformToUserOutput($user), Response::HTTP_CREATED);
	}
}
