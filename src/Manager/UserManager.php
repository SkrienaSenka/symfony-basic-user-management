<?php

namespace App\Manager;

use App\Entity\User;
use App\Model\Request\UserRegistrationInputRequest;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserManager
{
	public function __construct(
		private readonly EntityManagerInterface $doctrine,
		private readonly UserPasswordHasherInterface $passwordHasher,
	) {
	}

	public function register(UserRegistrationInputRequest $userRegistrationInputRequest): User
	{
		$user = new User();
		$user
			->setUsername($userRegistrationInputRequest->username)
			->setPseudo($userRegistrationInputRequest->pseudo)
			->setTag($userRegistrationInputRequest->tag)
			->setEmail($userRegistrationInputRequest->email)
			->setPassword($this->passwordHasher->hashPassword($user, $userRegistrationInputRequest->password))
		;

		$this->doctrine->persist($user);
		$this->doctrine->flush();

		return $user;
	}
}
