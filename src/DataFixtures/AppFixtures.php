<?php

namespace App\DataFixtures;

use App\Entity\Film;
use App\Entity\Genre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Création des genres
        $genres = [];
        $genreNames = ['Action', 'Comédie', 'Drame', 'Science-Fiction', 'Horreur'];

        foreach ($genreNames as $name) {
            $genre = new Genre();
            $genre->setLibelle($name);
            $manager->persist($genre);
            $genres[$name] = $genre;
        }

        $filmsData = [
            [
                'titre' => 'Star Wars: Un nouvel espoir',
                'genre' => 'Science-Fiction',
                'annee' => '1977-05-25',
                'duree' => 121,
                'synopsis' => "C'est la guerre civile. Les vaisseaux spatiaux rebelles, frappant depuis une base cachée, ont remporté leur première victoire contre le maléfique Empire Galactique.",
                'image' => '/images/star_wars_iv.jpg',
                'prix' => 10.99
            ],
            [
                'titre' => "Star Wars: L'Empire contre-attaque",
                'genre' => 'Science-Fiction',
                'annee' => '1980-05-21',
                'duree' => 124,
                'synopsis' => "C'est une époque sombre pour la Rébellion. Bien que l'Étoile de la Mort ait été détruite, les troupes impériales ont chassé les forces rebelles de leur base cachée.",
                'image' => '/images/star_wars_v.jpg',
                'prix' => 12.99
            ],
            [
                'titre' => 'Star Wars: Le Retour du Jedi',
                'genre' => 'Science-Fiction',
                'annee' => '1983-05-25',
                'duree' => 131,
                'synopsis' => "Luke Skywalker est retourné sur sa planète natale de Tatooine pour sauver Han Solo des griffes de Jabba le Hutt.",
                'image' => '/images/star_wars_vi.jpg',
                'prix' => 11.99
            ],
            [
                'titre' => 'Star Wars: La Menace fantôme',
                'genre' => 'Science-Fiction',
                'annee' => '1999-05-19',
                'duree' => 136,
                'synopsis' => "Deux chevaliers Jedi découvrent un jeune garçon exceptionnel qui pourrait apporter l’équilibre à la Force.",
                'image' => '/images/star_wars_i.jpg',
                'prix' => 9.99
            ],
            [
                'titre' => "Star Wars: L'Attaque des clones",
                'genre' => 'Science-Fiction',
                'annee' => '2002-05-16',
                'duree' => 142,
                'synopsis' => "Anakin Skywalker vit un amour interdit tandis qu’Obi-Wan enquête sur un complot menaçant la République.",
                'image' => '/images/star_wars_ii.jpg',
                'prix' => 9.99
            ],
            [
                'titre' => 'Star Wars: La Revanche des Sith',
                'genre' => 'Science-Fiction',
                'annee' => '2005-05-19',
                'duree' => 140,
                'synopsis' => "La République s’effondre et Anakin Skywalker bascule du côté obscur.",
                'image' => '/images/star_wars_iii.jpg',
                'prix' => 12.99
            ],
            [
                'titre' => 'Rogue One: A Star Wars Story',
                'genre' => 'Action',
                'annee' => '2016-12-16',
                'duree' => 133,
                'synopsis' => "Un groupe de rebelles tente de voler les plans de l’Étoile de la Mort.",
                'image' => '/images/rogue_one.jpg',
                'prix' => 13.99
            ],
            [
                'titre' => 'Solo: A Star Wars Story',
                'genre' => 'Action',
                'annee' => '2018-05-25',
                'duree' => 135,
                'synopsis' => "Les origines de Han Solo, du contrebandier à la légende.",
                'image' => '/images/solo.jpg',
                'prix' => 11.99
            ],
            [
                'titre' => 'Star Wars: Le Réveil de la Force',
                'genre' => 'Science-Fiction',
                'annee' => '2015-12-18',
                'duree' => 138,
                'synopsis' => "Une nouvelle menace surgit tandis qu’une jeune pilleuse découvre son lien avec la Force.",
                'image' => '/images/star_wars_vii.jpg',
                'prix' => 14.99
            ],
            [
                'titre' => 'Star Wars: Les Derniers Jedi',
                'genre' => 'Science-Fiction',
                'annee' => '2017-12-15',
                'duree' => 152,
                'synopsis' => "Rey cherche à comprendre la Force tandis que la Résistance lutte pour survivre.",
                'image' => '/images/star_wars_viii.jpg',
                'prix' => 14.99
            ],
            [
                'titre' => 'Star Wars: L’Ascension de Skywalker',
                'genre' => 'Science-Fiction',
                'annee' => '2019-12-20',
                'duree' => 142,
                'synopsis' => "La saga Skywalker touche à sa fin dans une bataille ultime entre le bien et le mal.",
                'image' => '/images/star_wars_ix.png',
                'prix' => 14.99
            ],
            [
                'titre' => 'Star Wars: Jar Jar Binks Contre Attaque',
                'genre' => 'Horreur',
                'annee' => '2025-12-17',
                'duree' => 142,
                'synopsis' => "La saga Skywalker doit affronter un dernier ennemi puissant, charismatique et qui ne répète jamais un mot spécifique.",
                'image' => '/images/mesa_empire_strikes_back.png',
                'prix' => 14.99
            ]
        ];

        foreach ($filmsData as $data) {
            $film = new Film();
            $film->setTitre($data['titre']);
            $film->setIdGenre($genres[$data['genre']]);
            $film->setAnneSortie(new \DateTime($data['annee']));
            $film->setDuree($data['duree']);
            $film->setSynopsis($data['synopsis']);
            $film->setImage($data['image']);
            $film->setPrixDefault($data['prix']);
            $manager->persist($film);
        }


        // Création de l'admin
        $admin = new \App\Entity\User();
        $admin->setNomUtilisateur('admin');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->hasher->hashPassword($admin, 'admin'));
        $manager->persist($admin);

        $manager->flush();
    }
}
