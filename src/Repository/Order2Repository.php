<?php

namespace App\Repository;

use App\Entity\Order2;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Order2|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order2|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order2[]    findAll()
 * @method Order2[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class Order2Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order2::class);
    }

    // /**
    //  * @return Order2[] Returns an array of Order2 objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Order2
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
