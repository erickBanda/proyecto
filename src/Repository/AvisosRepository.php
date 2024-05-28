<?php

namespace App\Repository;

use App\Entity\Avisos;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Avisos>
 *
 * @method Avisos|null find($id, $lockMode = null, $lockVersion = null)
 * @method Avisos|null findOneBy(array $criteria, array $orderBy = null)
 * @method Avisos[]    findAll()
 * @method Avisos[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AvisosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Avisos::class);
    }

//    /**
//     * @return Avisos[] Returns an array of Avisos objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Avisos
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
