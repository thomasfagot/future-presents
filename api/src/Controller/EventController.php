<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use App\Traits\FormError;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class EventController extends AbstractFOSRestController
{
    use FormError;

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

    #[Rest\Post('/events', name: 'events.new')]
    public function new(Request $request, EntityManagerInterface $entityManager): View
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($event);
            $entityManager->flush();

            return $this->view([
                'success' => true,
                'event' => $event
            ], Response::HTTP_CREATED);
        }

        return $this->view([
            'success' => false,
            'errors' => $form->isSubmitted() ? $this->getFormErrors($form) : [],
        ], Response::HTTP_BAD_REQUEST);
    }

    #[Rest\Put('/events/{id}', name: 'events.edit')]
    public function edit(Request $request, EntityManagerInterface $entityManager, Event $event): View
    {
        $form = $this->createForm(EventType::class, $event, ['method' => 'PUT']);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->view([
                'success' => true,
                'event' => $event
            ], Response::HTTP_OK);
        }

        return $this->view([
            'success' => false,
            'errors' => $form->isSubmitted() ? $this->getFormErrors($form) : [],
        ], Response::HTTP_BAD_REQUEST);
    }
}
