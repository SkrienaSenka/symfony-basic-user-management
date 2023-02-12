<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class UniqueUsername extends Constraint
{
	public const NOT_UNIQUE_ERROR = 'NOT_UNIQUE_ERROR';

	public string $message = 'This username is already used.';

	public function getTargets(): string
	{
		return self::PROPERTY_CONSTRAINT;
	}
}
