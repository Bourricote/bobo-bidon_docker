<?php

namespace App\Repository;

use App\Entity\UserSymptom;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method UserSymptom|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserSymptom|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserSymptom[]    findAll()
 * @method UserSymptom[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserSymptomRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserSymptom::class);
    }

    // /**
    //  * @return UserSymptom[] Returns an array of UserSymptom objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserSymptom
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
