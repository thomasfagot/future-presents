<?php

namespace App\Services\Listeners;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Cookie;

class RefreshTokenListener implements EventSubscriberInterface
{
    private bool $secure = false;

    public function __construct(private int $ttl)
    {
    }

    public function setRefreshToken(AuthenticationSuccessEvent $event): void
    {
        $data = $event->getData();
        $refreshToken = $data['refresh_token'];
        unset($data['refresh_token']);
        $event->setData($data);
        $ttl = (new \DateTime())->add(new \DateInterval('PT'.$this->ttl.'M'));
        $event->getResponse()->headers->setCookie(new Cookie(
            'REFRESH_TOKEN',
            $refreshToken,
            $ttl,
            '/',
            null,
            $this->secure,
        ));
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'lexik_jwt_authentication.on_authentication_success' => [
                ['setRefreshToken'],
            ]
        ];
    }
}