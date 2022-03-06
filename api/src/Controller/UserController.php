<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
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

    #[Rest\Post('/register', name: 'user.new')]
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
            if ($user->getPerson() && !$user->getPerson()->getAvatar()) {
                try {
                    $curl = \curl_init();
                    \curl_setopt_array($curl, [
                        CURLOPT_URL => 'https://www.gravatar.com/'.\md5(\strtolower(\trim($user->getEmail()))).'.json',
                        CURLOPT_TIMEOUT => 5,
                        CURLOPT_CONNECTTIMEOUT => 5,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:97.0) Gecko/20100101 Firefox/97.0',
                    ]);
                    $response = \json_decode(\curl_exec($curl), true, 512, JSON_THROW_ON_ERROR);
                    $user->getPerson()->setAvatar($response['entry'][0]['photos'][0]['value'] ?? null);
                } catch (\Exception) {
                }
            }

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

    #[Rest\Get('/users/me', name: 'user.me')]
    public function me(UserRepository $userRepository): View
    {
        return $this->view($userRepository->findWithJoins($this->getUser()), Response::HTTP_OK);
    }

    #[Rest\Get('/logout', name: 'user.logout')]
    public function logout(): Response
    {
        $response = new Response(null, Response::HTTP_NO_CONTENT);
        $response->headers->clearCookie('BEARER');
        $response->headers->clearCookie('refresh_token');

        return $response;
    }
}
