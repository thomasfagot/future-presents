<?php

namespace App\Services\Listeners;

use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\Serializer\SerializerInterface;

class AuthenticationSuccessListener
{
    public function __construct(private SerializerInterface $serializer)
    {
    }

    public function onAuthenticationSuccess(AuthenticationSuccessEvent $event): void
    {
        $data = $event->getData();
        $user = $event->getUser();

        if (!$user instanceof User) {
            return;
        }

        $data['data'] = \json_decode($this->serializer->serialize($user, 'json'), true, 512, JSON_THROW_ON_ERROR);

        $event->setData($data);
    }
}
