<?php

namespace App\Repository;

use App\Entity\Allergens;
use App\Entity\Diet;
use App\Entity\Recipe;
use App\Entity\RecipePicture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Common\Collections\Criteria;

/**
 * @extends ServiceEntityRepository<Recipe>
 *
 * @method Recipe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Recipe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Recipe[]    findAll()
 * @method Recipe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecipeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Recipe::class);
    }

    public function RecipeRequete($maxResult = 6, $currentPage = 0, $allergensList = [""], $dietList = [""]): array
    {   
        $requete = $this->createQueryBuilder('r')
        ->select(' 
            DISTINCT
            r.id AS id, 
            r.title, 
            r.description, 
            r.breakTime AS breakTime, 
            r.cookingTime AS cookingTime, 
            rp.name AS picture')
        ->leftJoin('r.picture', 'rp')
        ->leftJoin('r.allergens', 'ra')
        ->leftJoin('r.diet', 'rd')
        ->where('ra.name NOT IN (:allergens)')  //   ->where('ra.name NOT IN (:allergens)')
        ->andWhere('rd.name NOT IN (:diet)')    //   ->andWhere('rd.name NOT IN (:diet)')
        ->setParameter('allergens', $allergensList, \Doctrine\DBAL\Connection::PARAM_STR_ARRAY)
        ->setParameter('diet', $dietList, \Doctrine\DBAL\Connection::PARAM_STR_ARRAY)
        ->setMaxResults($maxResult)
        ->setFirstResult($currentPage)
        ->getQuery()  
        ->getResult();

        return $requete;
    }

    public function RecipeRequeteTotalPage($allergensList = [""], $dietList = [""]): array
    {   
        $requete = $this->createQueryBuilder('r')
        ->select('COUNT(DISTINCT r.title)')
        ->leftJoin('r.allergens', 'ra')
        ->leftJoin('r.diet', 'rd')
        ->where('ra.name NOT IN (:allergens)')
        ->andWhere('rd.name NOT IN (:diet)')
        ->setParameter('allergens', $allergensList, \Doctrine\DBAL\Connection::PARAM_STR_ARRAY)
        ->setParameter('diet', $dietList, \Doctrine\DBAL\Connection::PARAM_STR_ARRAY)
        ->getQuery()  
        ->getResult();

        return $requete;
    }
/*

        // 

        // ->setParameter('diet', $dietList, \Doctrine\DBAL\Connection::PARAM_STR_ARRAY)

*/

    
//    /**     
//     * @return Recipe[] Returns an array of Recipe objects
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

//    public function findOneBySomeField($value): ?Recipe
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
