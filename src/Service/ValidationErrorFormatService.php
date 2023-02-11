<?php

namespace App\Service;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IsNull;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Uuid;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationErrorFormatService
{
	public const ERROR_CODES = [
		Email::INVALID_FORMAT_ERROR => 'INVALID_FORMAT_ERROR',
		IsNull::NOT_NULL_ERROR => 'NOT_NULL_ERROR',
		Length::TOO_SHORT_ERROR => 'TOO_SHORT_ERROR',
		Length::TOO_LONG_ERROR => 'TOO_LONG_ERROR',
		Length::NOT_EQUAL_LENGTH_ERROR => 'NOT_EQUAL_LENGTH_ERROR',
		Length::INVALID_CHARACTERS_ERROR => 'INVALID_CHARACTERS_ERROR',
		NotBlank::IS_BLANK_ERROR => 'IS_BLANK_ERROR',
		Range::NOT_IN_RANGE_ERROR => 'NOT_IN_RANGE_ERROR',
		Regex::REGEX_FAILED_ERROR => 'REGEX_FAILED_ERROR',
		UniqueEntity::NOT_UNIQUE_ERROR => 'NOT_UNIQUE_ERROR',
		Uuid::TOO_SHORT_ERROR => 'TOO_SHORT_ERROR',
		Uuid::TOO_LONG_ERROR => 'TOO_LONG_ERROR',
		Uuid::INVALID_CHARACTERS_ERROR => 'INVALID_CHARACTERS_ERROR',
		Uuid::INVALID_HYPHEN_PLACEMENT_ERROR => 'INVALID_HYPHEN_PLACEMENT_ERROR',
		Uuid::INVALID_VERSION_ERROR => 'INVALID_VERSION_ERROR',
		Uuid::INVALID_VARIANT_ERROR => 'INVALID_VARIANT_ERROR',
	];

	public function formatErrors(ConstraintViolationListInterface $violationList): array
	{
		$errors = [];

		/** @var ConstraintViolation $violation */
		foreach ($violationList as $violation) {
			$errors[] = [
				$violation->getPropertyPath() => [
					'message' => $violation->getMessage(),
					'code' => self::ERROR_CODES[$violation->getCode()] ?? $violation->getCode(),
				]
			];
		}

		return $errors;
	}
}
