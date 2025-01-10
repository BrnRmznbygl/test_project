<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function findMatchingPosts(array $criteria)
    {
        $qb = $this->createQueryBuilder('p');

        // Correspondance sur les langages/technologies
        if (!empty($criteria['languages'])) {
            $qb->andWhere('JSON_CONTAINS(p.Technologie, :languages) = 1')
                ->setParameter('languages', json_encode($criteria['languages']));
        }

        // Correspondance sur la localisation
        if (!empty($criteria['Localisation'])) {
            $qb->andWhere('p.localisation = :localisation')
                ->setParameter('localisation', $criteria['Localisation']);
        }

        // Correspondance sur le salaire
        if (!empty($criteria['minSalary'])) {
            $qb->andWhere('p.salary >= :minSalary')
                ->setParameter('minSalary', $criteria['minSalary']);
        }

        // Correspondance sur le niveau d'expérience
        if (!empty($criteria['experienceLevel'])) {
            $qb->andWhere('p.experienceLevel = :experienceLevel')
                ->setParameter('experienceLevel', $criteria['experienceLevel']);
        }

        return $qb->getQuery()->getResult();
    }

    public function findMostViewedPosts(int $limit = 10)
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.views', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function findLatestPosts(int $limit = 3)
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.createdAt', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }


    //    /**
    //     * @return Post[] Returns an array of Post objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Post
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
