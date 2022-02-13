<?php

namespace App\Services\Listeners;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\HttpFoundation\Cookie;

class AuthenticationSuccessListener
{
    private bool $secure = false;

    public function __construct(private int $ttl)
    {
    }

    public function onAuthenticationSuccess(AuthenticationSuccessEvent $event): void
    {
        $data = $event->getData();
        $token = $data['token'];
        unset($data['token']);
        $event->setData($data);
        $ttl = (new \DateTime())->add(new \DateInterval('PT'.$this->ttl.'M'));
        $event->getResponse()->headers->setCookie(new Cookie(
            'BEARER',
            $token,
            $ttl,
            '/',
            null,
            $this->secure,
        ));
    }
}