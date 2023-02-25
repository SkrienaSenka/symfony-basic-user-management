<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\Event\LogoutEvent;

class LogoutSubscriber implements EventSubscriberInterface
{
	public function __construct(private readonly string $spaHomepageUrl)
	{
	}

	public static function getSubscribedEvents(): array
	{
		return [LogoutEvent::class => 'onLogout'];
	}

	public function onLogout(LogoutEvent $event): void
	{
		$response = new RedirectResponse($this->spaHomepageUrl);
		$event->setResponse($response);
	}
}
