<?php

namespace App\Model\Request\User;

use App\Entity\User;
use App\Service\UserTagService;
use App\Validator\UniqueEmail;
use App\Validator\UniquePseudoTag;
use App\Validator\UniqueUsername;
use Symfony\Component\Validator\Constraints as Assert;

#[Assert\GroupSequence(['UserUpdateInputRequest', 'DatabaseRequestsNeeded'])]
#[UniquePseudoTag(groups: ['DatabaseRequestsNeeded'])]
class UserUpdateInputRequest extends AbstractUserInputRequest
{
	#[Assert\Regex(pattern: User::PSEUDO_REGEX)]
	#[UniqueUsername(groups: ['DatabaseRequestsNeeded'])]
	public $username;

	#[Assert\Regex(pattern: User::PSEUDO_REGEX)]
	public $pseudo;

	#[Assert\Range(min: 0, max: UserTagService::MAX_TAG)]
	public $tag;

	#[Assert\Email]
	#[UniqueEmail(groups: ['DatabaseRequestsNeeded'])]
	public $email;
}
