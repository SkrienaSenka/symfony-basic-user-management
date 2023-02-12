<?php

namespace App\Model\Request;

use App\Entity\User;
use App\Validator\UniqueEmail;
use App\Validator\UniquePseudoTag;
use App\Validator\UniqueUsername;
use Symfony\Component\Validator\Constraints as Assert;

#[Assert\GroupSequence(['UserRegistrationInputRequest', 'DatabaseRequestsNeeded'])]
#[UniquePseudoTag(groups: ['DatabaseRequestsNeeded'])]
class UserRegistrationInputRequest implements InputRequestInterface
{
	#[Assert\NotBlank]
	#[Assert\Regex(pattern: User::PSEUDO_REGEX)]
	#[UniqueUsername(groups: ['DatabaseRequestsNeeded'])]
	public $username;

	#[Assert\NotBlank]
	#[Assert\Regex(pattern: User::PSEUDO_REGEX)]
	public $pseudo;

	#[Assert\NotBlank]
	#[Assert\Regex(pattern: '/^[0-9]{4}$/')]
	public $tag;

	#[Assert\NotBlank]
	#[Assert\Email]
	#[UniqueEmail(groups: ['DatabaseRequestsNeeded'])]
	public $email;

	#[Assert\NotBlank]
	#[Assert\Regex(pattern: User::PASSWORD_REGEX)]
	public $password;
}
