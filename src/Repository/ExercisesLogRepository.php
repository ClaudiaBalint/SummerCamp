<?php

namespace App\Repository;

use App\Entity\ExercisesLog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ExercisesLog>
 *
 * @method ExercisesLog|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExercisesLog|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExercisesLog[]    findAll()
 * @method ExercisesLog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExercisesLogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExercisesLog::class);
    }

//    /**
//     * @return ExercisesLog[] Returns an array of ExercisesLog objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ExercisesLog
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
