<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class UniqueEmail extends Constraint
{
	public const NOT_UNIQUE_ERROR = 'NOT_UNIQUE_ERROR';

	public string $message = 'This email is already verified on another account.';

	public function getTargets(): string
	{
		return self::PROPERTY_CONSTRAINT;
	}
}
