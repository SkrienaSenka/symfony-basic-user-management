<?php

namespace App\EventSubscriber;

use App\Exception\RequestValidationException;
use App\Model\Request\InputRequestInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ControllerArgumentsEvent;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ControllerArgumentsSubscriber implements EventSubscriberInterface
{
	public function __construct(
		protected readonly ValidatorInterface $validator,
		protected readonly SerializerInterface $serializer,
	) {
	}

	public static function getSubscribedEvents(): array
	{
		return [
			ControllerArgumentsEvent::class => 'onKernelControllerArguments',
		];
	}

	/**
	 * @throws RequestValidationException|\JsonException
	 */
	public function onKernelControllerArguments(ControllerArgumentsEvent $event)
	{
		$request = $event->getRequest();
		$content = json_encode(Request::METHOD_GET === $request->getMethod() ? $request->query->all() : $request->request->all(), JSON_THROW_ON_ERROR);
		$arguments = $event->getNamedArguments();
		$newArguments = [];

		foreach ($arguments as $argumentName => $argument) {
			if ($argument instanceof InputRequestInterface) {
				$argument = $this->serializer->deserialize($content, $argument::class, 'json', []);

				$errors = $this->validator->validate($argument);
				if (count($errors) > 0) {
					throw new RequestValidationException($errors);
				}
			}
			$newArguments[$argumentName] = $argument;
		}

		$event->setArguments($newArguments);
	}
}
