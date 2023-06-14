<?php

namespace App\Repository;

use App\Entity\Articlespresse;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Articlespresse>
 *
 * @method Articlespresse|null find($id, $lockMode = null, $lockVersion = null)
 * @method Articlespresse|null findOneBy(array $criteria, array $orderBy = null)
 * @method Articlespresse[]    findAll()
 * @method Articlespresse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticlespresseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private PaginatorInterface $paginator)
    {
        parent::__construct($registry, Articlespresse::class);
    }
    public function findPublished(int $page): PaginationInterface
    {
        /**
         * GET published articlespresse (publications)
         * PaginationInterface
         * * @param int $page
         * @return PaginationInterface
         */

         $data= $this->createQueryBuilder('a')
            ->where('a.state LIKE :state')
            ->setParameter('state', '%STATE_PUBLISHED%')
            ->addOrderBy('a.created_At', 'DESC')
            ->getQuery()
            ->getResult();
            $articlespresses=$this->paginator->paginate($data, $page, 4);
            
                return $articlespresses;
    }       
    // public function findPublished():array
    // {
    //     /**
    //      * GET published articlespresse (publications)
    //      * 
    //      * @return array
    //      */

    //     return $this->createQueryBuilder('a')
    //             ->where('a.state LIKE :state')
    //             ->setParameter('state', '%STATE_PUBLISHED%')
    //             ->addOrderBy('a.created_At', 'DESC')
    //             ->getQuery()
    //             ->getResult();
    // }



    //    /**
    //     * @return Articlespresse[] Returns an array of Articlespresse objects
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

    //    public function findOneBySomeField($value): ?Articlespresse
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
