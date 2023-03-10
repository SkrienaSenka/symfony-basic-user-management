<?php

namespace App\EventListener;

use App\Exception\RequestValidationException;
use App\Response\JsonResponse;
use App\Service\ValidationErrorFormatService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class RequestValidationExceptionListener
{
	public function __construct(private readonly ValidationErrorFormatService $validationErrorFormatService)
	{
	}

	public function onKernelException(ExceptionEvent $event): void
	{
		$exception = $event->getThrowable();

		if (!$exception instanceof RequestValidationException) {
			return;
		}

		$response = new JsonResponse(
			$this->validationErrorFormatService->formatErrors($exception->getViolationList()),
			Response::HTTP_UNPROCESSABLE_ENTITY,
		);

		$event->setResponse($response);
	}
}
