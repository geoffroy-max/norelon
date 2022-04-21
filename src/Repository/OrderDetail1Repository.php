<?php

namespace App\Repository;

use App\Entity\OrderDetail1;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OrderDetail1|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderDetail1|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderDetail1[]    findAll()
 * @method OrderDetail1[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderDetail1Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderDetail1::class);
    }

    // /**
    //  * @return OrderDetail1[] Returns an array of OrderDetail1 objects
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
    public function findOneBySomeField($value): ?OrderDetail1
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
