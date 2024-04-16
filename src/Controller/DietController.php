<?php

namespace App\Controller;

use App\Entity\Diet;
use App\Form\DietType;
use App\Repository\DietRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\Criteria;

#[Route('/diet')]
class DietController extends AbstractController
{
    #[Route('/{page<\d+>?1}', name: 'app_diet_index', methods: ['GET'])]
    public function index(DietRepository $dietRepository, int $page): Response
    {   // On défini le nombre de diet par page dans une variable
        $dietPerPage = 9;
        // On crée ensuite une variable qui contien les paramétres de notre méthode critéria
        $criteria = Criteria::create()
            ->setFirstResult(($page - 1) * $dietPerPage)  // Défine la premiére diet affiché
            ->setMaxResults($dietPerPage);  // Définie le nombre de diet affiché

        $diet = $dietRepository->matching($criteria); 

        $totaldiet = count($dietRepository->matching(Criteria::create()));

        $totalPages = ceil($totaldiet / $dietPerPage);
        return $this->render('diet/index.html.twig', [
            'diets' => $diet,
            'currentPage' => $page,
            'totalPages' => $totalPages
        ]);
    }

    #[Route('/new', name: 'app_diet_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $diet = new Diet();
        $form = $this->createForm(DietType::class, $diet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($diet);
            $entityManager->flush();

            return $this->redirectToRoute('app_diet_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('diet/new.html.twig', [
            'diet' => $diet,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_diet_show', methods: ['GET'])]
    public function show(Diet $diet): Response
    {
        return $this->render('diet/show.html.twig', [
            'diet' => $diet,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_diet_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Diet $diet, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DietType::class, $diet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_diet_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('diet/edit.html.twig', [
            'diet' => $diet,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_diet_delete', methods: ['POST'])]
    public function delete(Request $request, Diet $diet, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$diet->getId(), $request->request->get('_token'))) {
            $entityManager->remove($diet);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_diet_index', [], Response::HTTP_SEE_OTHER);
    }
}
