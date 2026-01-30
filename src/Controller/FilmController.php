<?php

namespace App\Controller;

use App\Entity\Favoris;
use App\Entity\Film;
use App\Entity\Note;
use App\Form\FilmType;
use App\Repository\FilmRepository;
use App\Repository\NoteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/film')]
final class FilmController extends AbstractController
{
    #[Route('', name: 'app_film_index', methods: ['GET'])]
    public function index(FilmRepository $filmRepository): Response
    {
        $user = $this->getUser();

        $favoris = [];
        if ($user) {
            $favoris = $user->getFavoris()->toArray();
        }

        $tousLesFilms = $filmRepository->findAll();

        $favorisFilms = array_map(fn($favoris) => $favoris->getIdFilm(), $favoris);

        $films = array_filter($tousLesFilms, function (Film $film) use ($favorisFilms) {
            return !in_array($film, $favorisFilms, true);
        });

        return $this->render('film/index.html.twig', [
            'favoris' => $favoris,
            'films' => $films,
        ]);
    }

    #[Route('/new', name: 'app_film_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $film = new Film();
        $form = $this->createForm(FilmType::class, $film);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($film);
            $entityManager->flush();

            return $this->redirectToRoute('app_film_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('film/new.html.twig', [
            'film' => $film,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_film_show', methods: ['GET'])]
    public function show(Film $film): Response
    {
        $user = $this->getUser();

        $favoris = [];
        if ($user) {
            $favorisEntities = $user->getFavoris()->toArray();
            $favoris = array_map(fn($f) => $f->getIdFilm(), $favorisEntities);
        }

        return $this->render('film/show.html.twig', [
            'film' => $film,
            'favoris' => $favoris,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_film_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Film $film, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FilmType::class, $film);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_film_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('film/edit.html.twig', [
            'film' => $film,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_film_delete', methods: ['POST'])]
    public function delete(Request $request, Film $film, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $film->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($film);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_film_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/favoris/toggle/{id}', name: 'app_favoris_toggle')]
    public function toggle(Film $film, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        if (!$user) {
            $this->addFlash('error', 'Vous devez être connecté.');
            return $this->redirectToRoute('app_login');
        }

        // regarde si le favorise existe
        $repository = $em->getRepository(Favoris::class);
        $existing = $repository->findOneBy([
            'id_user' => $user,
            'id_film' => $film
        ]);

        if ($existing) { // il existe donc on veux le supprimer
            // supprime des favories
            $em->remove($existing);
            $em->flush();
            $this->addFlash('success', 'Film retiré de vos favoris.');
        } else { // il n'existe pas donc on veux l'ajouter
            // ajoute dans les favories
            $favori = new Favoris();
            $favori->setIdUser($user);
            $favori->setIdFilm($film);
            $em->persist($favori);
            $em->flush();
            $this->addFlash('success', 'Film ajouté à vos favoris !');
        }
        return $this->redirectToRoute('app_film_show', ['id' => $film->getId()]);
    }

}
