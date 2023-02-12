<?php

namespace App\Validator;

use App\Repository\UserRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class UniqueUsernameValidator extends ConstraintValidator
{
	public function __construct(private readonly UserRepository $userRepository)
	{
	}

	public function validate($value, Constraint $constraint)
	{
		if (!$constraint instanceof UniqueUsername) {
			throw new UnexpectedTypeException($constraint, UniqueUsername::class);
		}

		if (!is_null($value) && $this->userRepository->findBy(['username' => $value])) {
			$this->context
				->buildViolation($constraint->message)
				->setInvalidValue($value)
				->setCode(UniqueUsername::NOT_UNIQUE_ERROR)
				->addViolation()
			;
		}
	}
}
