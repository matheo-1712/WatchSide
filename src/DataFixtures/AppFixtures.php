<?php

namespace App\DataFixtures;

use App\Entity\Film;
use App\Entity\Genre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
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

        // Création des films Star Wars
        $filmsData = [
            [
                'titre' => 'Star Wars: Un nouvel espoir',
                'genre' => 'Science-Fiction',
                'annee' => '1977-05-25',
                'duree' => 121,
                'synopsis' => "C'est la guerre civile. Les vaisseaux spatiaux rebelles, frappant depuis une base cachée, ont remporté leur première victoire contre le maléfique Empire Galactique.",
                'image' => '/images/mesa_empire_strikes_back.png',
                'prix' => 10.99
            ],
            [
                'titre' => "Star Wars: L'Empire contre-attaque",
                'genre' => 'Science-Fiction',
                'annee' => '1980-05-21',
                'duree' => 124,
                'synopsis' => "C'est une époque sombre pour la Rébellion. Bien que l'Étoile de la Mort ait été détruite, les troupes impériales ont chassé les forces rebelles de leur base cachée et les ont poursuivies à travers la galaxie.",
                'image' => '/images/mesa_empire_strikes_back.png',
                'prix' => 12.99
            ],
            [
                'titre' => 'Star Wars: Le Retour du Jedi',
                'genre' => 'Science-Fiction',
                'annee' => '1983-05-25',
                'duree' => 131,
                'synopsis' => "Luke Skywalker est retourné sur sa planète natale de Tatooine pour tenter de sauver son ami Han Solo des griffes du vil gangster Jabba le Hutt.",
                'image' => '/images/mesa_empire_strikes_back.png',
                'prix' => 11.99
            ],
            [
                'titre' => 'Star Wars: La Menace fantôme',
                'genre' => 'Science-Fiction',
                'annee' => '1999-05-19',
                'duree' => 136,
                'synopsis' => "Deux chevaliers Jedi échappent à un blocus hostile pour trouver des alliés et croisent un jeune garçon qui pourrait apporter l'équilibre à la Force.",
                'image' => '/images/mesa_empire_strikes_back.png',
                'prix' => 9.99
            ],
            [
                'titre' => "Star Wars: L'Attaque des clones",
                'genre' => 'Science-Fiction',
                'annee' => '2002-05-16',
                'duree' => 142,
                'synopsis' => "Dix ans après leur première rencontre, Anakin Skywalker partage une histoire d'amour interdite avec Padmé Amidala, tandis qu'Obi-Wan Kenobi enquête sur une tentative d'assassinat.",
                'image' => '/images/mesa_empire_strikes_back.png',
                'prix' => 9.99
            ],
            [
                'titre' => 'Star Wars: La Revanche des Sith',
                'genre' => 'Science-Fiction',
                'annee' => '2005-05-19',
                'duree' => 140,
                'synopsis' => "Trois ans après le début de la Guerre des Clones, les Jedi sauvent Palpatine du Comte Dooku. Alors qu'Obi-Wan poursuit une nouvelle menace, Anakin agit comme agent double.",
                'image' => '/images/mesa_empire_strikes_back.png',
                'prix' => 12.99
            ],
            [
                'titre' => 'Spaceballs (La Folle Histoire de l\'espace)',
                'genre' => 'Comédie',
                'annee' => '1987-06-24',
                'duree' => 96,
                'synopsis' => "Une parodie culte de Star Wars où Lone Starr et son fidèle Barf doivent sauver la princesse Vespa des griffes de Lord Casque Noir.",
                'image' => '/images/mesa_empire_strikes_back.png',
                'prix' => 7.99
            ],
            [
                'titre' => 'Rogue One: A Star Wars Story',
                'genre' => 'Action',
                'annee' => '2016-12-16',
                'duree' => 133,
                'synopsis' => "La fille d'un scientifique impérial rejoint l'Alliance Rebelle dans une mission risquée pour voler les plans de l'Étoile de la Mort.",
                'image' => '/images/mesa_empire_strikes_back.png',
                'prix' => 13.99
            ],
            [
                'titre' => 'Solo: A Star Wars Story',
                'genre' => 'Action',
                'annee' => '2018-05-25',
                'duree' => 135,
                'synopsis' => "Au cours d'une aventure dans un monde criminel sombre, Han Solo rencontre son futur copilote Chewbacca et croise la route du joueur Lando Calrissian.",
                'image' => '/images/mesa_empire_strikes_back.png',
                'prix' => 11.99
            ],
            [
                'titre' => 'Fanboys',
                'genre' => 'Comédie',
                'annee' => '2009-02-06',
                'duree' => 90,
                'synopsis' => "Des fans de Star Wars voyagent à travers le pays jusqu'au ranch de George Lucas pour voir l'épisode I avant sa sortie officielle.",
                'image' => '/images/mesa_empire_strikes_back.png',
                'prix' => 6.99
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

        $manager->flush();
    }
}
