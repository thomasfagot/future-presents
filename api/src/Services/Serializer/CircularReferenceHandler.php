<?php

namespace App\Services\Serializer;

use App\Entity\Event;
use App\Entity\Item;
use App\Entity\Network;
use App\Entity\Person;
use App\Entity\Reservation;
use App\Entity\Wish;
use Symfony\Component\Routing\RouterInterface;

class CircularReferenceHandler
{
    public function __construct(private RouterInterface $router)
    {
    }

    public function __invoke($object): string
    {
        return match (true) {
            $object instanceof Event => $this->router->generate('event.view', ['id' => $object->getId()]),
            $object instanceof Item => $this->router->generate('item.view', ['id' => $object->getId()]),
            $object instanceof Network => $this->router->generate('network.view', ['id' => $object->getId()]),
            $object instanceof Person => $this->router->generate('person.view', ['id' => $object->getId()]),
            $object instanceof Reservation => $this->router->generate('reservation.view', ['id' => $object->getId()]),
            $object instanceof Wish => $this->router->generate('wish.view', ['id' => $object->getId()]),
            default => $object->getId(),
        };
    }
}