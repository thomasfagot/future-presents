<?php

namespace App\Controller;

use App\Repository\NetworkRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

class PersonController extends AbstractFOSRestController
{
    #[Rest\Get('/person/{id}/networks')]
    public function networks(NetworkRepository $networkRepository, int $id): View
    {
        return $this->view($networkRepository->findForPerson($id), Response::HTTP_OK);
    }
}
