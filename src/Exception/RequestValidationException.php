<?php

namespace App\Exception;

use Symfony\Component\Validator\ConstraintViolationListInterface;

class RequestValidationException extends \Exception
{
	public function __construct(private readonly ConstraintViolationListInterface $violationList, $code = 0, $previous = null)
	{
		parent::__construct('Request validation failed', $code, $previous);
	}

	public function getViolationList(): ConstraintViolationListInterface
	{
		return $this->violationList;
	}
}
