<?php

namespace App\Repository;

use App\Entity\Linea;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Linea|null find($id, $lockMode = null, $lockVersion = null)
 * @method Linea|null findOneBy(array $criteria, array $orderBy = null)
 * @method Linea[]    findAll()
 * @method Linea[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LineaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Linea::class);
    }

    // /**
    //  * @return Linea[] Returns an array of Linea objects
    //  */
    
    public function getTotalRecords($tipo = null)
    {
        $qb = $this->createQueryBuilder('l')
        ->select('count(l.id)');
        if($tipo == 'telefono'){
            $qb->where('l.tipo = 1 AND l.internet = 0');
        }
        if($tipo == 'internet'){
            $qb->where('l.tipo = 1 AND l.internet = 1');
        }
        if($tipo == 'modem'){
            $qb->where('l.tipo = 2');
        }
        return $qb->getQuery()->getSingleScalarResult();
    }
    

    /*
    public function findOneBySomeField($value): ?Linea
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
