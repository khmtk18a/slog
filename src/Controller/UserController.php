<?php

namespace App\Controller;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/google/login', name: 'app_google_login')]
    public function login(ClientRegistry $clientRegistry): RedirectResponse
    {
        return $clientRegistry->getClient('google')->redirect(['profile'], []);
    }

    #[Route('/google/callback', name: 'app_google_callback')]
    public function callback(): void
    {
    }

    #[Route('/user/logout', name: 'app_user_logout')]
    public function logout(): void
    {
    }

    #[Route('/user/info', name: 'app_api_get_user')]
    public function getUserInfo(): JsonResponse
    {
        return $this->json(['user' => $this->getUser()]);
    }
}
