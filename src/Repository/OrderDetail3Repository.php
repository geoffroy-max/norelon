<?php

namespace App\Repository;

use App\Entity\OrderDetail3;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OrderDetail3|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderDetail3|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderDetail3[]    findAll()
 * @method OrderDetail3[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderDetail3Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderDetail3::class);
    }

    // /**
    //  * @return OrderDetail3[] Returns an array of OrderDetail3 objects
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
    public function findOneBySomeField($value): ?OrderDetail3
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
