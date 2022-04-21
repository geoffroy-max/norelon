<?php

namespace App\Repository;

use App\Entity\OrderdetailS1;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OrderdetailS1|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderdetailS1|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderdetailS1[]    findAll()
 * @method OrderdetailS1[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderdetailS1Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderdetailS1::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(OrderdetailS1 $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(OrderdetailS1 $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return OrderdetailS1[] Returns an array of OrderdetailS1 objects
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
    public function findOneBySomeField($value): ?OrderdetailS1
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
