<?php

namespace App\Services\Listeners;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class RequestListener implements EventSubscriberInterface
{
    public function onKernelRequest(RequestEvent $event): void
    {
        $event->getRequest()->attributes->set('refresh_token', $event->getRequest()->cookies->get('REFRESH_TOKEN'));
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => [
                ['onKernelRequest'],
            ]
        ];
    }
}