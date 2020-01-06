<?php

namespace App\Repository;

use App\Entity\ContactReq;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ContactReq|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContactReq|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContactReq[]    findAll()
 * @method ContactReq[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactReqRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContactReq::class);
    }

    // /**
    //  * @return ContactReq[] Returns an array of ContactReq objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ContactReq
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
