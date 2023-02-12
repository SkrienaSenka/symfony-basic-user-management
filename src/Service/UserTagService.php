<?php

namespace App\Service;

use App\Repository\UserRepository;

class UserTagService
{
	public const MAX_TAG = 9999;

	public function __construct(private readonly UserRepository $userRepository)
	{
	}

	public function getTag(string $pseudo): int
	{
		$usedTags = $this->userRepository->getUsedTagsForPseudo($pseudo);

		if (count($usedTags) > self::MAX_TAG) {
			return -1;
		}

		$allowedTags = array_values(array_diff(range(0, self::MAX_TAG), $usedTags));

		return $allowedTags[rand(0, count($allowedTags) - 1)];
	}
}
