<?php

namespace App\Repository;

use App\Classe\Search;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function findWithSearch(Search $search)
    {
    // je veux que les id de mon entité category soit dans les categories que je vs envoyé dans la recherche ou search
       $query= $this->createQueryBuilder('p')
              ->select('p', 'c')
              ->join('p.category', 'c');
       if(!empty($search->categories)) {
           $query = $query
               ->andWhere('c.id IN (:categories)')
               ->setParameter('categories', $search->categories);
          }
        if(!empty($search->nom)) {
            // est ce que le name du produit ressemble  au nom que  je t'envoi à la recherche
            //"%{$search->nom}%": fait les recherche sur tt ce qui se termmine par ce nom(ex:bonnet)
            $query = $query
                ->andWhere('p.name LIKE :nom')
                ->setParameter('nom', "%{$search->nom}%");
        }
           return $query->getQuery()->getResult();
    }
    // /**
    //  * @return Product[] Returns an array of Product objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
