<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/welcome')]
class WelcomeController extends AbstractController
{
    #[Route('/', name: 'app_welcome_index', methods: ['GET'])]
    public function index(): Response
    {
        // Page d’accueil simple
        return $this->render('welcome/index.html.twig');
    }

    #[Route('/{name}/{sex}', name: 'app_welcome_index_custom', requirements: ['sex' => 'h|f'], methods: ['GET'])]
    public function indexCustom(string $name, string $sex): Response
    {
        // Sécurisation basique des paramètres utilisateur
        $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
        $sex = htmlspecialchars($sex, ENT_QUOTES, 'UTF-8');

        $civility = $sex === 'f' ? 'Madame' : 'Monsieur';

        return $this->render('welcome/index_custom.html.twig', [
            'name' => ucfirst($name),
            'civility' => $civility,
        ]);
    }
}
