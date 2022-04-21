<?php

namespace App\Repository;

use App\Entity\Order3;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Order3|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order3|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order3[]    findAll()
 * @method Order3[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class Order3Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order3::class);
    }


    public function findSuccessOrder($user){

        return $this->createQueryBuilder('o')
            ->andWhere('o.state>0')
            ->andWhere('o.user=  :user')
            ->setParameter('user' , $user)
             ->orderBy('o.id' ,'DESC')
            ->getQuery()
            ->getResult();
    }
    // /**
    //  * @return Order3[] Returns an array of Order3 objects
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
    public function findOneBySomeField($value): ?Order3
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
