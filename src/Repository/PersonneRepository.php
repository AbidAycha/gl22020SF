<?php

namespace App\Repository;

use App\Entity\Personne;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Personne|null find($id, $lockMode = null, $lockVersion = null)
 * @method Personne|null findOneBy(array $criteria, array $orderBy = null)
 * @method Personne[]    findAll()
 * @method Personne[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Personne::class);
    }

    // /**
    //  * @return Personne[] Returns an array of Personne objects
    //  */

    /**
     * @param $min
     * @param $max
     * @param null $limit
     */
    public function personnesInIntervalAge($min, $max, $limit = null)
    {
        // select * from Personne p where p.age > :minAge and p.age < :maxAge
         $qb =  $this->createQueryBuilder('p');
         $qb->andWhere('p.age <= :maxAge and p.age >= :minAge')
            ->setParameter('minAge', $min)
            ->setParameter('maxAge', $max)
            ->orderBy('p.id', 'ASC');
         if ($limit) {
             $qb->setMaxResults($limit);
         }
        return $qb->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?Personne
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
