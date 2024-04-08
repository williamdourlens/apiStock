<?php

namespace App\Repository;

use App\Entity\CompositionPlats;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CompositionPlats>
 *
 * @method CompositionPlats|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompositionPlats|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompositionPlats[]    findAll()
 * @method CompositionPlats[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompositionPlatsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompositionPlats::class);
    }

    //    /**
    //     * @return CompositionPlats[] Returns an array of CompositionPlats objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?CompositionPlats
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
