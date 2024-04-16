<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\Criteria;

#[Route('/recette')]
class RecetteController extends AbstractController
{
    
    #[Route('/{page<\d+>?1}', name: 'app_recette_index', methods: ['GET'])]
    public function index(
        RecipeRepository $recipeRepository,
        int $page, 
        EntityManagerInterface $entityManager
        ): Response
    {   // On défini le nombre de recette par page dans une variable
        $allergens = [""];
        $diet = [""];
        $recipePerPage = 6;
        $user = $this->getUser();

        
        if($user == null){
            $criteria = Criteria::create()
            ->where(Criteria::expr()->gt('public', 0))
            ->setFirstResult(($page - 1) * $recipePerPage)  // Défine la premiére recette affiché
            ->setMaxResults($recipePerPage);  // Définie le nombre de recette affiché

            $recipes = $recipeRepository->matching($criteria);
            $arrayList = [];
            foreach ($recipes as $value){
                $array = [];
                $array ['id'] = $value->getId();
                $array ['picture'] = $value->picture[0]->name;
                $array ['title'] = $value->getTitle();
                $array ['description'] = $value->getDescription();
                $array ['breakTime'] = $value->getBreakTime();
                $array ['cookingTime'] = $value->getCookingTime();

                array_push($arrayList, $array);
            }
            $recipes = $arrayList;

            $totalRecipes = count($recipeRepository->matching(Criteria::create()->where(Criteria::expr()->gt('public', 0))));
    
            $totalPages = ceil($totalRecipes / $recipePerPage);

        } else {
            $userAllergens = $user->Allergens;

            foreach ($userAllergens as $value) {
                array_push($allergens, $value->id); 
            }

            $userDiets = $user->Diet;

            foreach ($userDiets as $value) {
                array_push($diet, $value->id);
            }
            
            $currentPage = ($page - 1) * $recipePerPage;
            
            $recipes = $recipeRepository->RecipeRequete($recipePerPage, $currentPage, $allergens, $diet);

            $totalRecipes = $recipeRepository->RecipeRequeteTotalPage($allergens, $diet);
            $totalPages = ceil($totalRecipes[0][1] / $recipePerPage);
        }   

        return $this->render('recette/recette.html.twig', [
            'recipes' => $recipes,
            'currentPage' => $page,
            'totalPages' => $totalPages
        ]);
    }

    #[Route('/{id}/detail', name: 'app_recette_detail', methods: ['GET'])]
    public function show(RecipeRepository $recipeRepository, Recipe $recette, int $id): Response
    {
        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq('id', $id));

        $recette = $recipeRepository->matching($criteria);
        $recette = $recette[0];
        
        return $this->render('recette/detail.html.twig', [
            'recette' => $recette,
        ]);
    }
}