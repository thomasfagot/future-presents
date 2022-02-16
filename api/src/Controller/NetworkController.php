<?php

namespace App\Controller;

use App\Entity\Network;
use App\Repository\NetworkRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class NetworkController extends AbstractFOSRestController
{
    #[Rest\Get('/networks', name: 'network.index')]
    public function index(NetworkRepository $networkRepository, #[CurrentUser] $user): View
    {
        return $this->view($networkRepository->findForPerson($user->getPerson()), Response::HTTP_OK);
    }

    #[Rest\Get('/networks/{id}', name: 'network.view')]
    public function get(Network $network): View
    {
        return $this->view($network, Response::HTTP_OK);
    }
}
