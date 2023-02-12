<?php

namespace App\Validator;

use App\Repository\UserRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class UniqueEmailValidator extends ConstraintValidator
{
	public function __construct(private readonly UserRepository $userRepository)
	{
	}

	public function validate($value, Constraint $constraint)
	{
		if (!$constraint instanceof UniqueEmail) {
			throw new UnexpectedTypeException($constraint, UniqueEmail::class);
		}

		if (!is_null($value) && $this->userRepository->findOneBy(['email' => $value, 'isEmailVerified' => true])) {
			$this->context
				->buildViolation($constraint->message)
				->setInvalidValue($value)
				->setCode(UniqueEmail::NOT_UNIQUE_ERROR)
				->addViolation()
			;
		}
	}
}
