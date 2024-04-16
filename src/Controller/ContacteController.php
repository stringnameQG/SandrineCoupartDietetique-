<?php

namespace App\Controller;

use App\Entity\Contacte;
use App\Form\ContacteType;
use App\Repository\ContacteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\Criteria;

#[Route('/contacte')]
class ContacteController extends AbstractController
{
    #[Route('/{page<\d+>?1}', name: 'app_contacte_index', methods: ['GET'])]
    public function index(ContacteRepository $contacteRepository, int $page): Response
    {   // On défini le nombre de contacte par page dans une variable
        $contactePerPage = 9;
        // On crée ensuite une variable qui contien les paramétres de notre méthode critéria
        $criteria = Criteria::create()
            ->setFirstResult(($page - 1) * $contactePerPage)  // Défine la premiére contacte affiché
            ->setMaxResults($contactePerPage);  // Définie le nombre de contacte affiché

        $contacte = $contacteRepository->matching($criteria); 

        $totalcontacte = count($contacteRepository->matching(Criteria::create()));

        $totalPages = ceil($totalcontacte / $contactePerPage);
        return $this->render('contacte/index.html.twig', [
            'contactes' => $contacte,
            'currentPage' => $page,
            'totalPages' => $totalPages
        ]);

        return $this->render('contacte/index.html.twig', [
            'contactes' => $contacteRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_contacte_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $contacte = new Contacte();
        $form = $this->createForm(ContacteType::class, $contacte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($contacte);
            $entityManager->flush();

            return $this->redirectToRoute('app_contacte_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('contacte/new.html.twig', [
            'contacte' => $contacte,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_contacte_show', methods: ['GET'])]
    public function show(Contacte $contacte): Response
    {
        return $this->render('contacte/show.html.twig', [
            'contacte' => $contacte,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_contacte_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Contacte $contacte, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ContacteType::class, $contacte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_contacte_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('contacte/edit.html.twig', [
            'contacte' => $contacte,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_contacte_delete', methods: ['POST'])]
    public function delete(Request $request, Contacte $contacte, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contacte->getId(), $request->request->get('_token'))) {
            $entityManager->remove($contacte);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_contacte_index', [], Response::HTTP_SEE_OTHER);
    }
}
