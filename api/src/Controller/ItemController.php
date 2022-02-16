<?php

namespace App\Controller;

use App\Entity\Item;
use App\Repository\ItemRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class ItemController extends AbstractFOSRestController
{
    #[Rest\Get('/items', name: 'item.index')]
    public function index(ItemRepository $itemRepository, #[CurrentUser] $user): View
    {
       return $this->view($itemRepository->findForPerson($user->getPerson()), Response::HTTP_OK);
    }

    #[Rest\Get('/items/{id}', name: 'item.view')]
    public function get(Item $item): View
    {
        return $this->view($item, Response::HTTP_OK);
    }
}
