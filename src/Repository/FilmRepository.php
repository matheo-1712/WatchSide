<?php

namespace App\Repository;

use App\Entity\Film;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Film>
 */
class FilmRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Film::class);
    }

    /**
     * @return Film[]
     */
    public function search(?string $query = null, ?int $genreId = null): array
    {
        $qb = $this->createQueryBuilder('f');

        if ($query) {
            $qb->andWhere('f.titre LIKE :query')
                ->setParameter('query', '%' . $query . '%');
        }

        if ($genreId) {
            $qb->andWhere('f.id_genre = :genreId')
                ->setParameter('genreId', $genreId);
        }

        return $qb->getQuery()->getResult();
    }
}
