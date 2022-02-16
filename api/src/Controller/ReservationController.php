<?php

namespace App\Controller;

use App\Entity\Reservation;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

class ReservationController extends AbstractFOSRestController
{
    #[Rest\Get('/reservations/{id}', name: 'reservation.view')]
    public function get(Reservation $reservation): View
    {
        return $this->view($reservation, Response::HTTP_OK);
    }
}
