<?php

namespace App\Repository;

use App\Entity\RecipePicture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RecipePicture>
 *
 * @method RecipePicture|null find($id, $lockMode = null, $lockVersion = null)
 * @method RecipePicture|null findOneBy(array $criteria, array $orderBy = null)
 * @method RecipePicture[]    findAll()
 * @method RecipePicture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecipePictureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RecipePicture::class);
    }

//    /**
//     * @return RecipePicture[] Returns an array of RecipePicture objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?RecipePicture
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
