<?php

namespace App\Repository;

use App\Entity\UserLinea;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserLinea|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserLinea|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserLinea[]    findAll()
 * @method UserLinea[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserLineaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserLinea::class);
    }

    // /**
    //  * @return UserLinea[] Returns an array of UserLinea objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserLinea
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
