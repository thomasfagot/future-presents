<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use App\Traits\FormError;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    use FormError;

    #[Route('/register', name: 'user', methods: 'post')]
    public function register(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user
                ->setPassword($passwordHasher->hashPassword($user, $user->getPlainPassword()))
                ->setRoles(['ROLE_USER'])
                ->eraseCredentials()
            ;
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->json([
                'success' => true,
                'user' => $user
            ]);
        }

        return $this->json([
            'success' => false,
            'errors' => $form->isSubmitted() ? $this->getFormErrors($form) : [],
        ]);
    }
}
