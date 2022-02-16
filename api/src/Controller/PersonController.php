<?php

namespace App\Controller;

use App\Entity\Person;
use App\Repository\PersonRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class PersonController extends AbstractFOSRestController
{
    #[Rest\Get('/persons', name: 'person.index')]
    public function index(PersonRepository $personRepository, #[CurrentUser] $user): View
    {
        return $this->view($personRepository->findForPerson($user->getPerson()), Response::HTTP_OK);
    }

    #[Rest\Get('/persons/{id}', name: 'person.view')]
    public function get(Person $person): View
    {
        return $this->view($person, Response::HTTP_OK);
    }
}
