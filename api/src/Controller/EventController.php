<?php

namespace App\Controller;

use App\Entity\Event;
use App\Repository\EventRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class EventController extends AbstractFOSRestController
{
    #[Rest\Get('/events', name: 'event.index')]
    public function index(EventRepository $eventRepository, #[CurrentUser] $user): View
    {
       return $this->view($eventRepository->findForPerson($user->getPerson()), Response::HTTP_OK);
    }

    #[Rest\Get('/events/{id}', name: 'event.view')]
    public function get(Event $event): View
    {
        return $this->view($event, Response::HTTP_OK);
    }
}
