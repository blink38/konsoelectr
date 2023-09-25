<?php

namespace App\Repository;

use App\Entity\Import;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Import>
 *
 * @method Import|null find($id, $lockMode = null, $lockVersion = null)
 * @method Import|null findOneBy(array $criteria, array $orderBy = null)
 * @method Import[]    findAll()
 * @method Import[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Import::class);
    }

    public function infoImport($id)
    {

        return $this->createQueryBuilder('i')
            ->select('min(r.date) as start, max(r.date) as end, count(distinct r.id) as count, count(distinct s.id) as simulation')
            ->leftJoin('App\Entity\Releve', 'r', 'WITH', 'i.id = r.import')
            ->leftJoin('App\Entity\Simulation', 's', 'WITH', 'i.id = s.data')
            ->where('i.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getSingleResult();
    }


    public function delete($id): bool
    {

        try {
            $this->createQueryBuilder('r')
                ->delete('App\Entity\Releve', 'r')
                ->where('r.import = :id')
                ->setParameter('id', $id)
                ->getQuery()
                ->execute();

            $this->createQueryBuilder('r')
                ->delete('App\Entity\Simulation', 's')
                ->where('s.data = :id')
                ->setParameter('id', $id)
                ->getQuery()
                ->execute();

            $this->createQueryBuilder('i')
                ->delete('App\Entity\Import', 'i')
                ->where('i.id = :id')
                ->setParameter('id', $id)
                ->getQuery()
                ->execute();
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }


    //    /**
    //     * @return Import[] Returns an array of Import objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('i')
    //            ->andWhere('i.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('i.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Import
    //    {
    //        return $this->createQueryBuilder('i')
    //            ->andWhere('i.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
