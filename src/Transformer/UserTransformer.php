<?php

namespace App\Transformer;

use App\Entity\User;
use App\Model\UserOutput;
use Symfony\Bundle\SecurityBundle\Security;

class UserTransformer
{
	public function __construct(private readonly Security $security)
	{
	}

	public function transformToUserOutput(User $user): UserOutput
	{
		$userOutput = new UserOutput();

		$loggedUser = $this->security->getUser();

		if ($loggedUser && $loggedUser->getUserIdentifier() === $user->getUserIdentifier()) {
			$userOutput->setUsername($user->getUsername());
			$userOutput->setEmail($user->getEmail());
		}

		$userOutput->setPseudo($user->getPseudo());
		$userOutput->setTag($user->getTag());

		return $userOutput;
	}
}
