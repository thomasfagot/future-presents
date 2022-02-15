<?php

namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractFOSRestController
{
    #[Rest\Get('/', name: 'home')]
    public function home(): View
    {
        return $this->view(['message' => 'Hello'], Response::HTTP_OK);
    }
}