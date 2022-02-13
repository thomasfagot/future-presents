<?php

namespace App\Controller;

use App\Repository\EventRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

class EventController extends AbstractFOSRestController
{
    #[Rest\Get('/events')]
    public function index(EventRepository $eventRepository): array
    {
       return $eventRepository->findAll();
    }
}
