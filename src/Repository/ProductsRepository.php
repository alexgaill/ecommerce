<?php

namespace App\Repository;

use App\Entity\Products;
use App\Entity\Stock;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
// use Doctrine\ORM\Query\Expr\Comparison;
// use Doctrine\Common\Collections\Expr\Comparison;

/**
 * @method Products|null find($id, $lockMode = null, $lockVersion = null)
 * @method Products|null findOneBy(array $criteria, array $orderBy = null)
 * @method Products[]    findAll()
 * @method Products[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Products::class);
    }

    /**
     * @return Products[] Returns an array of Products objects
     */
    
    public function set_codes()
    {
        return $this->createQueryBuilder('p')
            ->select('SUBSTRING(p.set_code, 1,4) AS set, COUNT(p.id) AS totalCard')
            ->groupBy('set')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Products[] Returns an array of Products objects
     */

    public function countCard($value)
    {
        return $this->createQueryBuilder('p')
            ->select('COUNT(s.'.$value.') AS '.$value)
            // ->select('COUNT('.new Comparison('s.new', '>', '0').') AS new, COUNT(s.correct > 0) AS correct, COUNT(s.occasion > 0) AS occasion, COUNT(s.abimee > 0) AS abimee')
            ->join('App\Entity\Stock', 's', 'WITH', 'p.id = s.card_id')
            ->where('s.'.$value.' > 0')
            // ->where('s.new > 0 OR s.correct > 0 OR s.occasion > 0 OR s.abimee > 0')
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /**
     * @return Products[] Returns an array of Products objects
     */
    public function findAllGrouped()
    {
        return $this->createQueryBuilder('p')
            ->groupBy('p.name')
            ->getQuery()
            ->getResult()
        ;
    }
    
    // /**
    //  * @return Products[] Returns an array of Products objects
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
    public function findOneBySomeField($value): ?Products
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
