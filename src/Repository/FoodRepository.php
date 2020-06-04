<?php

namespace App\Repository;

use App\Entity\Food;
use App\Entity\FoodSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Food|null find($id, $lockMode = null, $lockVersion = null)
 * @method Food|null findOneBy(array $criteria, array $orderBy = null)
 * @method Food[]    findAll()
 * @method Food[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FoodRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Food::class);
    }

    public function findAllQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('f')
            ->orderBy('f.name', 'ASC');
    }

    /**
     * @param FoodSearch $search
     * @return mixed
     */
    public function findByFoodSearchQuery(FoodSearch $search)
    {
        $query = $this->findAllQuery();

        if ($search->getSearchText()) {
            $words = explode(' ', $search->getSearchText());
            $clause = '';
            $parameters = [];

            $i = 0;
            foreach ($words as $word) {
                $parameters[':val' . $i] = '%' . $word . '%';
                if ($i === 0) {
                    $clause = 'f.name LIKE :val'. $i;
                } else {
                    $clause .= ' AND f.name LIKE :val'. $i;
                }
                $i++;
            } $query = $query
                ->andWhere($clause)
                ->setParameters($parameters);
        }

        if ($search->getCategory()) {
            $query = $query
                ->join('f.category', 'c')
                ->andwhere('c.name = :category')
                ->setParameter('category', $search->getCategory()->getName());
        }


        return $query->getQuery()->getResult();
    }
}
