<?php

namespace App\Repository;

use App\Entity\Operadora;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Operadora|null find($id, $lockMode = null, $lockVersion = null)
 * @method Operadora|null findOneBy(array $criteria, array $orderBy = null)
 * @method Operadora[]    findAll()
 * @method Operadora[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OperadoraRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Operadora::class);
    }

    // /**
    //  * @return Operadora[] Returns an array of Operadora objects
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
    public function findOneBySomeField($value): ?Operadora
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
