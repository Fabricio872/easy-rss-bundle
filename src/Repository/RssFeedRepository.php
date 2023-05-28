<?php

namespace Fabricio872\EasyRssBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Fabricio872\EasyRssBundle\Entity\RssFeed;

/**
 * @extends ServiceEntityRepository<RssFeed>
 *
 * @method RssFeed|null find($id, $lockMode = null, $lockVersion = null)
 * @method RssFeed|null findOneBy(array $criteria, array $orderBy = null)
 * @method RssFeed[]    findAll()
 * @method RssFeed[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RssFeedRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RssFeed::class);
    }

    public function save(RssFeed $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(RssFeed $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return RssFeed[] Returns an array of RssFeed objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?RssFeed
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
