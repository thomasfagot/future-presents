<?php

namespace App\Controller;

use App\Entity\Person;
use App\Repository\NetworkRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

class PersonController extends AbstractFOSRestController
{
    #[Rest\Get('/persons/{id}/networks')]
    public function networks(NetworkRepository $networkRepository, Person $person): View
    {
        return $this->view($networkRepository->findForPerson($person), Response::HTTP_OK);
    }
}
