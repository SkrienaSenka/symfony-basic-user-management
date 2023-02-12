<?php

namespace App\Validator;

use App\Model\Request\UserRegistrationInputRequest;
use App\Repository\UserRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class UniquePseudoTagValidator extends ConstraintValidator
{
	public function __construct(private readonly UserRepository $userRepository)
	{
	}

	public function validate($value, Constraint $constraint)
	{
		if (!$value instanceof UserRegistrationInputRequest) {
			throw new UnexpectedTypeException($value, UserRegistrationInputRequest::class);
		}

		if (!$constraint instanceof UniquePseudoTag) {
			throw new UnexpectedTypeException($constraint, UniquePseudoTag::class);
		}

		if (
			!is_null($value->pseudo) &&
			!is_null($value->tag) &&
			$this->userRepository->findBy(['pseudo' => $value->pseudo, 'tag' => $value->tag])
		) {
			$this->context
				->buildViolation($constraint->message)
				->setInvalidValue($value->pseudo . ':' . $value->tag)
				->atPath('pseudo:tag')
				->setCode(UniquePseudoTag::NOT_UNIQUE_ERROR)
				->addViolation()
			;
		}
	}
}
