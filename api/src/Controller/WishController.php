<?php

namespace App\Controller;

use App\Entity\Wish;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

class WishController extends AbstractFOSRestController
{
    #[Rest\Get('/wishs/{id}', name: 'wish.view')]
    public function get(Wish $wish): View
    {
        return $this->view($wish, Response::HTTP_OK);
    }
}
