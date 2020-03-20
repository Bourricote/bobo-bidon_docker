<?php

namespace App\Repository;

use App\Entity\UserFood;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method UserFood|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserFood|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserFood[]    findAll()
 * @method UserFood[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserFoodRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserFood::class);
    }

    // /**
    //  * @return UserFood[] Returns an array of UserFood objects
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
    public function findOneBySomeField($value): ?UserFood
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
