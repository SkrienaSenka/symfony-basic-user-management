<?php

namespace App\Controller;

use App\Entity\User;
use App\Manager\UserManager;
use App\Model\Request\User\UserUpdateInputRequest;
use App\Response\JsonResponse;
use App\Service\UserTagService;
use App\Transformer\UserTransformer;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/api/users')]
class UserController extends AbstractController
{
	public function __construct(
		private readonly UserTagService $userTagService,
		private readonly UserManager $userManager,
		private readonly UserTransformer $userTransformer,
	) {
	}

	#[Route(path: '/me', name: 'me', methods: ['GET'])]
	public function me(): JsonResponse
	{
		/* @var User $user */
		$user = $this->getUser();
		return new JsonResponse($this->userTransformer->transformToUserOutput($user));
	}

	#[Route(path: '/{user}', name: 'read_user', methods: ['GET'])]
	public function read(User $user): JsonResponse
	{
		return new JsonResponse($this->userTransformer->transformToUserOutput($user));
	}

	#[Route(path: '/{user}', name: 'update_user', methods: ['PATCH'])]
	#[Route(path: '/is_valid', name: 'is_valid_user', methods: ['OPTIONS'])]
	public function update(Request $request, UserUpdateInputRequest $userUpdateInputRequest, ?User $user = null): JsonResponse
	{
		if (Request::METHOD_OPTIONS === $request->getMethod())
		{
			return new JsonResponse();
		}

		/* @var User $currentUser */
		$currentUser = $this->getUser();

		if (
			!$user ||
			(!$this->isGranted(User::ROLE_ADMIN) && $currentUser->getUserIdentifier() !== $user->getUserIdentifier())
		) {
			throw new AccessDeniedException();
		}

		$this->userManager->update($user, $userUpdateInputRequest);
		return new JsonResponse($this->userTransformer->transformToUserOutput($user));
	}

	#[Route(path: '/{pseudo}/tag', name: 'get_tag', methods: ['GET'])]
	public function getTag(string $pseudo): JsonResponse
	{
		$tag = $this->userTagService->getTag($pseudo);

		if ($tag === -1) {
			return new JsonResponse(null, Response::HTTP_UNPROCESSABLE_ENTITY);
		}
		return new JsonResponse($tag);
	}
}
