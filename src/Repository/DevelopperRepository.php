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
    // src/Repository/DevelopperRepository.php

    public function findBySearchCriteria(array $criteria)
    {
        $qb = $this->createQueryBuilder('d');

        if (!empty($criteria['firstName'])) {
            $qb->andWhere('d.firstName LIKE :firstName')
                ->setParameter('firstName', '%' . $criteria['firstName'] . '%');
        }

        if (!empty($criteria['lastName'])) {
            $qb->andWhere('d.lastName LIKE :lastName')
                ->setParameter('lastName', '%' . $criteria['lastName'] . '%');
        }

        if (!empty($criteria['Localisation'])) {
            $qb->andWhere('d.Localisation LIKE :Localisation')
                ->setParameter('Localisation', '%' . $criteria['Localisation'] . '%');
        }

        if (!empty($criteria['experienceLevel'])) {
            $qb->andWhere('d.experienceLevel = :experienceLevel')
                ->setParameter('experienceLevel', $criteria['experienceLevel']);
        }

        if (!empty($criteria['languages'])) {
            foreach ($criteria['languages'] as $key => $language) {
                $qb->andWhere('d.languages LIKE :language' . $key)
                    ->setParameter('language' . $key, '%"' . $language . '"%');
            }
        }

        if (!empty($criteria['minSalary'])) {
            $qb->andWhere('d.minSalary >= :minSalary')
                ->setParameter('minSalary', $criteria['minSalary']);
        }

        return $qb->getQuery()->getResult();
    }
}
