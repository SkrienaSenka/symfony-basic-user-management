<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class UniquePseudoTag extends Constraint
{
	public const NOT_UNIQUE_ERROR = 'NOT_UNIQUE_ERROR';

	public string $message = 'This pseudo and tag combination is already used.';

	public function getTargets(): string
	{
		return self::CLASS_CONSTRAINT;
	}
}
