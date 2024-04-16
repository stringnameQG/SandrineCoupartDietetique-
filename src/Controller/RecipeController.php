<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Entity\RecipePicture;
use App\Form\RecipeType;
use App\Repository\RecipeRepository;
use App\Service\PictureService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\Common\Collections\Criteria;

#[Route('/recipe')]
class RecipeController extends AbstractController
{
    #[Route('/{page<\d+>?1}', name: 'app_recipe_index', methods: ['GET'])]
    public function index(RecipeRepository $recipeRepository, int $page): Response
    {   // On défini le nombre de recette par page dans une variable
        $recipePerPage = 9;
        // On crée ensuite une variable qui contien les paramétres de notre méthode critéria
        $criteria = Criteria::create()
            ->setFirstResult(($page - 1) * $recipePerPage)  // Défine la premiére recette affiché
            ->setMaxResults($recipePerPage);  // Définie le nombre de recette affiché

        $recipes = $recipeRepository->matching($criteria);

        $totalRecipes = count($recipeRepository->matching(Criteria::create()));

        $totalPages = ceil($totalRecipes / $recipePerPage);
        return $this->render('recipe/index.html.twig', [
            'recipes' => $recipes,
            'currentPage' => $page,
            'totalPages' => $totalPages
        ]);
    }

    #[Route('/new', name: 'app_recipe_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request, 
        EntityManagerInterface $entityManager,
        PictureService $pictureService
    ): Response
    {
        $recipe = new Recipe();

        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // On récupère les images transmises
            $pictures = $form->get('pictures')->getData();

            // On boucle sur les images 
            foreach($pictures as $picture) {

                $fichier = $pictureService->add($picture);

                // On stocke l'image dans la base de données (son nom)
                $img = new RecipePicture();
                $img->setName($fichier);
                $recipe->addPicture($img);
            }

            $entityManager->persist($recipe);
            $entityManager->flush();

            return $this->redirectToRoute('app_recipe_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('recipe/new.html.twig', [
            'recipe' => $recipe,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_recipe_show', methods: ['GET'])]
    public function show(Recipe $recipe): Response
    {
        return $this->render('recipe/show.html.twig', [
            'recipe' => $recipe,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_recipe_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request, 
        Recipe $recipe, 
        EntityManagerInterface $entityManager,
        PictureService $pictureService
    ): Response
    {
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // On récupère les images transmises
            $pictures = $form->get('pictures')->getData();

            // On boucle sur les images 
            foreach($pictures as $picture) {

                $fichier = $pictureService->add($picture);

                // On stocke l'image dans la base de données (son nom)
                $img = new RecipePicture();
                $img->setName($fichier);
                $recipe->addPicture($img);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_recipe_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('recipe/edit.html.twig', [
            'recipe' => $recipe,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_recipe_delete', methods: ['POST'])]
    public function delete(Request $request, Recipe $recipe, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$recipe->getId(), $request->request->get('_token'))) {
            $entityManager->remove($recipe);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_recipe_index', [], Response::HTTP_SEE_OTHER);
    }  

    #[Route('/delete/image/{id}', name: 'app_recipe_delete_image', methods: ['DELETE'])]
    public function deleteImage(
        RecipePicture $image, 
        Request $request,
        EntityManagerInterface $em
    ): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        
        //On vérifie si le token est valide
        if($this->isCsrfTokenValid('delete'. $image->getId(), $data['_token'])){
            // Récupération du nom de l'image
            $nom = $image->getName();

            // suppression du fichier
            unlink($this->getParameter('images_directory').'/'.$nom);

            // Supression de la bdd
            // $em = $this->getDoctrine()->getManager();
            $em->remove($image);
            $em->flush();

            // On répond en json
            return new JsonResponse(['success' => true], 200);

        }else{
            return new JsonResponse(['error' => 'Token Invalide'], 400);
        }
    }
}
