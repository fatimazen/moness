<?php

namespace App\Repository;

use App\Entity\GeoLocalisationEss;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GeoLocalisationEss>
 *
 * @method GeoLocalisationEss|null find($id, $lockMode = null, $lockVersion = null)
 * @method GeoLocalisationEss|null findOneBy(array $criteria, array $orderBy = null)
 * @method GeoLocalisationEss[]    findAll()
 * @method GeoLocalisationEss[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GeoLocalisationEssRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GeoLocalisationEss::class);
    }

    public function save(GeoLocalisationEss $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(GeoLocalisationEss $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return GeoLocalisationEss[] Returns an array of GeoLocalisationEss objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('g.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?GeoLocalisationEss
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
