<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class JsonRequestSubscriber implements EventSubscriberInterface
{
	public static function getSubscribedEvents(): array
	{
		return [
			KernelEvents::REQUEST => ['onKernelRequest', 100],
		];
	}

	public function onKernelRequest(RequestEvent $event): void
	{
		if ('json' === $event->getRequest()->getContentTypeFormat() && $event->getRequest()->getContent()) {
			try {
				$data = json_decode($event->getRequest()->getContent(), true, 512, JSON_THROW_ON_ERROR);

				$event->getRequest()->request->replace(is_array($data) ? $data : []);
			} catch (\JsonException $exception) {
				throw new BadRequestHttpException('Invalid json body: ' . $exception->getMessage(), $exception);
			}
		}
	}
}
