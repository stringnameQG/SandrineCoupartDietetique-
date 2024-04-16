<?php

namespace App\Controller;

use App\Entity\View;
use App\Form\ViewType;
use App\Repository\ViewRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\Criteria;

#[Route('/view')]
class ViewController extends AbstractController
{
    #[Route('/{page<\d+>?1}', name: 'app_view_index', methods: ['GET'])]
    public function index(ViewRepository $viewRepository, int $page): Response
    {   // On défini le nombre de recette par page dans une variable
        $viewPerPage = 20;
        // On crée ensuite une variable qui contien les paramétres de notre méthode critéria
        $criteria = Criteria::create()
            ->setFirstResult(($page - 1) * $viewPerPage)  // Défine la premiére recette affiché
            ->setMaxResults($viewPerPage);  // Définie le nombre de recette affiché

        $views = $viewRepository->matching($criteria);

        $totalviews = count($viewRepository->matching(Criteria::create()));

        $totalPages = ceil($totalviews / $viewPerPage);
        return $this->render('view/index.html.twig', [
            'views' => $views,
            'currentPage' => $page,
            'totalPages' => $totalPages 
        ]);
    }

    #[Route('/new', name: 'app_view_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $view = new View();
        $form = $this->createForm(ViewType::class, $view);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($view);
            $entityManager->flush();

            return $this->redirectToRoute('app_view_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('view/new.html.twig', [
            'view' => $view,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_view_show', methods: ['GET'])]
    public function show(View $view): Response
    {
        return $this->render('view/show.html.twig', [
            'view' => $view,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_view_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, View $view, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ViewType::class, $view);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_view_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('view/edit.html.twig', [
            'view' => $view,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_view_delete', methods: ['POST'])]
    public function delete(Request $request, View $view, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$view->getId(), $request->request->get('_token'))) {
            $entityManager->remove($view);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_view_index', [], Response::HTTP_SEE_OTHER);
    }
}
