<?php

namespace App\Repository;

use App\Entity\Developper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Developper>
 */
class DevelopperRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Developper::class);
    }

    public function findMostViewedProfiles(int $limit): array
    {
        return $this->createQueryBuilder('d')
            ->orderBy('d.views', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function findLatestProfiles(int $limit): array
    {
        return $this->createQueryBuilder('d')
            ->orderBy('d.createdAt', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function findMatchingDeveloppers(array $criteria)
    {
        $qb = $this->createQueryBuilder('d');

        // Correspondance sur les langages/technologies
        if (!empty($criteria['Technologie'])) {
            $qb->andWhere(':Technologie MEMBER OF d.languages')
               ->setParameter('Technologie', $criteria['Technologie']);
        }

        // Correspondance sur la localisation
        if (!empty($criteria['localisation'])) {
            $qb->andWhere('d.Localisation = :localisation')
               ->setParameter('localisation', $criteria['localisation']);
        }

        // Correspondance sur le salaire
        if (!empty($criteria['salary'])) {
            $qb->andWhere('d.minSalary <= :salary')
               ->setParameter('salary', $criteria['salary']);
        }

        // Correspondance sur le niveau d'expérience
        if (!empty($criteria['experienceLevel'])) {
            $qb->andWhere('d.experienceLevel = :experienceLevel')
               ->setParameter('experienceLevel', $criteria['experienceLevel']);
        }

        return $qb->getQuery()->getResult();
    }
}
