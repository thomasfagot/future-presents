<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Traits\FormError;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractFOSRestController
{
    use FormError;

    #[Rest\Post('/register')]
    public function register(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): View
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user
                ->setPassword($passwordHasher->hashPassword($user, $user->getPlainPassword()))
                ->setRoles(['ROLE_USER'])
                ->eraseCredentials()
            ;
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->view([
                'success' => true,
                'user' => $user
            ], Response::HTTP_CREATED);
        }

        return $this->view([
            'success' => false,
            'errors' => $form->isSubmitted() ? $this->getFormErrors($form) : [],
        ], Response::HTTP_BAD_REQUEST);
    }
}
