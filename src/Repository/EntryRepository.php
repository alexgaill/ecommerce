<?php

namespace App\Repository;

use App\Entity\Entry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Entry|null find($id, $lockMode = null, $lockVersion = null)
 * @method Entry|null findOneBy(array $criteria, array $orderBy = null)
 * @method Entry[]    findAll()
 * @method Entry[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Entry::class);
    }

    /**
     * @return Entry[] Returns an array of Entry objects
     */
    
    public function quantity($value)
    {
        return $this->createQueryBuilder('e')
            ->select("SUM(e.new) AS new, SUM(e.correct) AS correct, SUM(e.occasion) AS occasion, SUM(e.abimee) AS abimee")
            ->andWhere('e.id_arrivage = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            // ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    
    /**
     * @return Entry[] Returns an array of Entry objects
     */
    
    public function getEntriesWithName($value)
    {
        return $this->createQueryBuilder('e')
            ->select('e.new, e.correct, e.occasion, e.abimee, p.name AS name, p.id, p.setCode AS setCode')
            ->andWhere('e.id_arrivage = :val')
            ->setParameter('val', $value)
            ->join('App\Entity\Stock', 's', 'WITH', 'e.id_stock = s.id')
            ->join('App\Entity\Products', 'p', 'WITH', 's.card_id = p.id')
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?Entry
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
