<?php

namespace App\Repository;

use Doctrine\ORM\Query;
use App\Entity\Products;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

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
            ->select('SUBSTRING(p.setCode, 1,4) AS set, COUNT(p.id) AS totalCard')
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
            ->orderBy('p.setCode')
            ->getQuery()
            ->getResult()
        ;
    }

        /**
     * @return Products[] Returns an array of Products objects
     */
    public function findSearch($value)
    {
        return $this->createQueryBuilder('p')
            ->orWhere('p.name LIKE :val')
            ->orWhere('p.description LIKE :val')
            ->orWhere('p.type LIKE :val')
            ->orWhere('p.race LIKE :val')
            ->orWhere('p.archetype LIKE :val')
            ->orWhere('p.setName LIKE :val')
            ->orWhere('p.setCode LIKE :val')
            ->orWhere('p.attribute LIKE :val')
            ->setParameter('val', '%' . $value . '%')
            ->orderBy('p.setCode')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Products[]
     */
    public function findAllName()
    {
        return $this->createQueryBuilder('p')
            ->select('p.id, p.name, p.setCode')
            // ->groupBy('p.name')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Products[] Returns an array of Products objects
     */
    public function setSearch($value)
    {
        return $this->createQueryBuilder('p')
                    ->select('p.setCode, p.setName, p.id, p.name')
                    ->where('p.name = :val')
                    ->setParameter('val', $value)
                    ->getQuery()
                    ->getResult()
        ;
    }

    /**
     * @return Products[]
     */

    public function findCost($value)
    {
        return $this->createQueryBuilder('p')
            ->select('p.cost')
            ->where('p.setCode = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /**
     * @return Products[]
     */

    public function findId($value)
    {
        return $this->createQueryBuilder('p')
            ->select('p.id')
            ->where('p.setCode = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /**
     * @return Products
     */

    public function findIdQuery($value)
    {
        return $this->createQueryBuilder('p')
            ->where('p.setCode = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
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
