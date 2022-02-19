<?php

namespace App\Controller;

use App\Entity\Network;
use App\Form\NetworkType;
use App\Repository\NetworkRepository;
use App\Repository\PersonRepository;
use App\Traits\FormError;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class NetworkController extends AbstractFOSRestController
{
    use FormError;

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

    #[Rest\Post('/networks', name: 'networks.new')]
    public function new(Request $request, EntityManagerInterface $entityManager, PersonRepository $personRepository): View
    {
        $network = new Network();
        $form = $this->createForm(NetworkType::class, $network);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $personRepository->findOneForUser($this->getUser())?->addNetworkCollection($network);
            $entityManager->persist($network);
            $entityManager->flush();

            return $this->view([
                'success' => true,
                'network' => $network
            ], Response::HTTP_CREATED);
        }

        return $this->view([
            'success' => false,
            'errors' => $form->isSubmitted() ? $this->getFormErrors($form) : [],
        ], Response::HTTP_BAD_REQUEST);
    }
}
