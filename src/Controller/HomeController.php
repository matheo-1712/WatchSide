<?php

namespace App\Controller;

use App\Repository\FilmRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(FilmRepository $filmRepository): Response
    {
        // Fetch latest 3 films as featured
        $latestFilms = $filmRepository->findBy([], ['id' => 'DESC'], 3);

        return $this->render('home/index.html.twig', [
            'films' => $latestFilms,
        ]);
    }
}
