<?php

namespace App\Repository;

use App\Entity\Blog;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * @extends ServiceEntityRepository<Blog>
 *
 * @method Blog|null find($id, $lockMode = null, $lockVersion = null)
 * @method Blog|null findOneBy(array $criteria, array $orderBy = null)
 * @method Blog[]    findAll()
 * @method Blog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry,private PaginatorInterface $paginatorInterface)
    {
        parent::__construct($registry, Blog::class);
    }

    public function findPublished(int $page):PaginationInterface
    {
        /**
         * GET published blog (publications)
         * @param int $page
         * @return PaginationInterface
         */

        $data= $this->createQueryBuilder('b')
                ->where('b.state LIKE :state')
                ->setParameter('state', '%STATE_PUBLISHED%')
                ->addOrderBy('b.created_At', 'DESC')
                ->getQuery()
                ->getResult();
                $articleBlogs=$this->paginatorInterface->paginate($data, $page, 4);
                return $articleBlogs;
    }

//    /**
//     * @return Blog[] Returns an array of Blog objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Blog
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
